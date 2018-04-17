<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChannelRepository;
use App\Contracts\Repositories\CommentRepository as CommentRepositoryContract;
use App\Entities\Comment;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Support\Collection;

class CommentRepository extends Repository implements CommentRepositoryContract
{

    /**
     * Получение списка комментариев канала
     *
     * @param string $channelId
     * @return Collection
     */
    public function getChannelComments(string $channelId): Collection
    {
        $channelRepository = $this->app->make(ChannelRepository::class);
        $channel = $channelRepository->show($channelId);

        return $this->cache()->remember(md5('channel_comments'.$channelId), now()->addHour(), function () use ($channel) {
            return $channel->comments()
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) use ($channel) {
                    $comment->setRelation('channel', $channel);

                    return new CommentResource($comment);
                });
        });
    }

    /**
     * Получение списка всех комментариев канала, написанных ботами
     *
     * @param string $channelId
     * @return Collection
     */
    public function getChannelSpamComments(string $channelId): Collection
    {
        $channelRepository = $this->app->make(ChannelRepository::class);
        $channel = $channelRepository->show($channelId);

        return $this->cache()->remember(md5('channel_bots_comments'.$channelId), now()->addHour(), function () use ($channel) {
            return $this->model->newQuery()
                ->join('videos', 'videos.id', '=', 'comments.video_id')
                ->where('videos.channel_id', $channel->id)
                ->onlySpam()
                ->with('channel')
                ->get(['comments.*'])
                ->map(function ($comment) {
                    return new CommentResource($comment);
                });
        });
    }

    /**
     * Пометка комментариев канала как спам
     *
     * @param string $channelId
     */
    public function markChannelCommentsAsSpam(string $channelId): void
    {
        Comment::whereChannelId($channelId)->update([
            'is_spam' => true
        ]);
    }

    /**
     * Пометка комментариев канала как нормальные
     *
     * @param string $channelId
     */
    public function markChannelCommentsAsNormal(string $channelId): void
    {
        Comment::whereChannelId($channelId)->update([
            'is_spam' => false
        ]);
    }

    /**
     * @return array
     */
    public function cacheTags(): array
    {
        return ['comments'];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Comment::class;
    }
}