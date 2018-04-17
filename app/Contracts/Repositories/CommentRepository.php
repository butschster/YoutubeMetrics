<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface CommentRepository
{
    /**
     * Получение списка всех комментариев канала, написанных ботами
     *
     * @param string $channelId
     * @return Collection
     */
    public function getChannelSpamComments(string $channelId): Collection;

    /**
     * Получение списка комментариев канала
     *
     * @param string $channelId
     * @return Collection
     */
    public function getChannelComments(string $channelId): Collection;

    /**
     * Пометка комментариев канала как спам
     *
     * @param string $channelId
     */
    public function markChannelCommentsAsSpam(string $channelId): void;

    /**
     * Пометка комментариев канала как нормальные
     *
     * @param string $channelId
     */
    public function markChannelCommentsAsNormal(string $channelId): void;
}