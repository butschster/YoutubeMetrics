<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChannelRepository as ChannelRepositoryContract;
use App\Contracts\Repositories\CommentRepository;
use App\Entities\Channel;
use App\Entities\FollowedChannel;
use App\Http\Resources\Channel\ChannelResource;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ChannelRepository extends Repository implements ChannelRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Channel::class;
    }

    /**
     * @param int|string $id
     * @return Channel
     */
    public function show($id): Channel
    {
        return $this->cache()->remember($this->geChannelCacheKey($id), now()->addHour(), function () use ($id) {
            return parent::show($id);
        });
    }

    /**
     * Получение типа канала по ID
     *
     * @param string $id
     * @return string
     */
    public function getChannelType(string $id): string
    {
        return $this->show($id)->type;
    }

    /**
     * Получение полного списка каналов ботов.
     *
     * @return Collection
     */
    public function getBotChannels(): Collection
    {
        return $this->cache()->remember(md5('channel.bot.list'), now()->addHour(), function () {
            return $this->model->newQuery()
                ->onlyBots()
                ->live()
                ->orderBy('total_comments')
                ->get();
        });
    }

    /**
     * Получение списка ботов, зарегистрированных в дату
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getBotChannelsRegisteredAt(Carbon $date): Collection
    {
        return $this->model->newQuery()
            ->onlyBots()
            ->whereRaw('date(created_at) = ?')
            ->orderByDesc('total_comments')
            ->addBinding($date->toDateString())
            ->get();
    }

    /**
     * Получение списка каналов, не верифицированных и не ботов, зарегистрированных в переданную дату
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getNonBotChannelsRegisteredAt(Carbon $date): Collection
    {
        return $this->model->newQuery()
            ->filterBots()
            ->filterVerified()
            ->whereRaw('date(created_at) = ?')
            ->orderByDesc('total_comments')
            ->addBinding($date->toDateString())
            ->get();
    }

    /**
     * Получение списка каналов, сгрупированных по дате создания
     *
     * @return Collection
     */
    public function getChannelsGroupedByCreationDate(): Collection
    {
        return $this->cache()->remember(__CLASS__, now()->addHour(), function () {
            return $this->model->newQuery()
                ->onlyBots()
                ->orderBy('created_at')
                ->get()
                ->map(function (Channel $channel) {
                    return new ChannelResource($channel);
                })
                ->groupBy(function ($channel) {
                    return Carbon::parse($channel->created_at)->format('d.m.Y');
                })
                ->sortByDesc(function (Collection $bots) {
                    return $bots->count();
                })
                ->toArray();
        });
    }

    /**
     * Получение списка видео канала
     *
     * @param string $channelId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getChannelVideos(string $channelId, int $perPage): LengthAwarePaginator
    {
        $channel = $this->show($channelId);

        return $channel->videos()->with('channel')->latest()->paginate($perPage);
    }

    /**
     * Получение списка каналов, за которыми производится слежение
     *
     * @return Collection
     */
    public function getFollowingChannels(): Collection
    {
        return $this->cache()->remember('following-channels', now()->addHour(), function () {
            return FollowedChannel::with('channel')->whereHas('channel')->get()
                ->map(function (FollowedChannel $channel) {
                    return $channel->channel;
                })
                ->sortByDesc('subscribers');
        });
    }

    /**
     * Получения списка людей, отправивших жалобу на канал
     *
     * @param string $channelId
     * @return Collection
     */
    public function getReportersForChannel(string $channelId): Collection
    {
        $channel = $this->show($channelId);

        return $channel->reports()->with('reporter')->get();
    }

    /**
     * Пометка канала как спам
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsBot(string $channelId, int $moderatorId): void
    {
        $commentRepository = $this->app->make(CommentRepository::class);
        $channel = $this->show($channelId);

        $channel->update([
            'bot' => true,
            'moderated_by' => $moderatorId
        ]);

        $commentRepository->markChannelCommentsAsSpam($channelId);
    }

    /**
     * Пометка канала как проверенный
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsVerified(string $channelId, int $moderatorId): void
    {
        $commentRepository = $this->app->make(CommentRepository::class);
        $channel = $this->show($channelId);

        $channel->update([
            'verified' => true,
            'bot' => false,
            'moderated_by' => $moderatorId
        ]);

        $commentRepository->markChannelCommentsAsNormal($channelId);
    }

    /**
     * Пометка канала как нормального
     *
     * при этом у него остаюстя репорты, которые можно убрать при верификации
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsNormal(string $channelId, int $moderatorId): void
    {
        $commentRepository = $this->app->make(CommentRepository::class);
        $channel = $this->show($channelId);

        $channel->update([
            'bot' => false,
            'moderated_by' => $moderatorId
        ]);

        $commentRepository->markChannelCommentsAsNormal($channelId);
    }

    /**
     * Отправка репорта на канал
     *
     * @param string $channelId
     * @param int $reporterId
     * @throws ChannelReportedException
     */
    public function sendReport(string $channelId, int $reporterId): void
    {
        if ($this->hasReportFrom($channelId, $reporterId)) {
            throw new ChannelReportedException("Channel {$channelId} reported by user {$reporterId}");
        }

        $channel = $this->show($channelId);
        $channel->increment('total_reports');

        $channel->reports()->create([
            'user_id' => $reporterId
        ]);
    }

    /**
     * Проверка наличия репорта от пользователя
     *
     * @param string $channelId
     * @param int $reporterId
     * @return bool
     */
    public function hasReportFrom(string $channelId, int $reporterId): bool
    {
        $channel = $this->show($channelId);

        return $channel->reports()->where('user_id', $reporterId)->exists();
    }


    /**
     * Получение списка каналов, которые имеют жалобы, но еще не боты
     *
     * @return Collection
     */
    public function getReportedChannels(): Collection
    {
        return $this->model->newQuery()
            ->onlyReported()
            ->live()
            ->get();
    }

    /**
     * @param string|Channel $id
     * @return string
     */
    public function geChannelCacheKey($id): string
    {
        if ($id instanceof Channel) {
            $id = $id->getKey();
        }

        return md5('channel'.$id);
    }

    /**
     * @return array
     */
    public function cacheTags(): array
    {
        return ['channels'];
    }
}