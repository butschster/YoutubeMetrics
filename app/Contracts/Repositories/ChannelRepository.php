<?php

namespace App\Contracts\Repositories;

use App\Repositories\ChannelReportedException;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ChannelRepository extends Repository
{
    /**
     * Получение типа канала по ID
     *
     * @param string $id
     * @return string
     */
    public function getChannelType(string $id): string;

    /**
     * Получение полного списка каналов ботов.
     *
     * @return Collection
     */
    public function getBotChannels(): Collection;

    /**
     * Получение списка ботов, зарегистрированных в дату
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getBotChannelsRegisteredAt(Carbon $date): Collection;

    /**
     * Получение списка каналов, сгрупированных по дате создания
     *
     * @return Collection
     */
    public function getChannelsGroupedByCreationDate(): Collection;

    /**
     * Получение списка каналов, не верифицированных и не ботов, зарегистрированных в переданную дату
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getNonBotChannelsRegisteredAt(Carbon $date): Collection;

    /**
     * Получение списка видео канала
     *
     * @param string $channelId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getChannelVideos(string $channelId, int $perPage): LengthAwarePaginator;

    /**
     * Получение списка каналов, за которыми производится слежение
     *
     * @return Collection
     */
    public function getFollowingChannels(): Collection;

    /**
     * Получения списка людей, отправивших жалобу на канал
     *
     * @param string $channelId
     * @return Collection
     */
    public function getReportersForChannel(string $channelId): Collection;

    /**
     * Получение списка каналов, которые имеют жалобы, но еще не боты
     *
     * @return Collection
     */
    public function getReportedChannels(): Collection;

    /**
     * Пометка канала как спам
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsBot(string $channelId, int $moderatorId): void;

    /**
     * Пометка канала как проверенный
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsVerified(string $channelId, int $moderatorId): void;

    /**
     * Пометка канала как нормального
     *
     * при этом у него остаюстя репорты, которые можно убрать при верификации
     *
     * @param string $channelId
     * @param int $moderatorId
     */
    public function markAsNormal(string $channelId, int $moderatorId): void;

    /**
     * Отправка репорта на канал
     *
     * @param string $channelId
     * @param int $reporterId
     * @throws ChannelReportedException
     */
    public function sendReport(string $channelId, int $reporterId): void;

    /**
     * Проверка наличия репорта от пользователя
     *
     * @param string $channelId
     * @param int $reporterId
     * @return bool
     */
    public function hasReportFrom(string $channelId, int $reporterId): bool;
}