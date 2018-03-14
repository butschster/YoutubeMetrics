<?php

namespace App\Contracts\Services\Youtube;

use App\Services\Youtube\Resources\{
    Video
};
use App\Services\Youtube\ResponseCollection;
use App\Services\Youtube\ResponseException;

interface Client
{
    /**
     * Поиск видео по ID
     *
     * @param string $id
     * @return Video
     * @throws ResponseException
     */
    public function getVideoInfo($id);

    /**
     * Поиск канала по ID
     *
     * @param string $id
     * @param bool $optionalParams
     * @return mixed
     */
    public function getChannelById($id, $optionalParams = false);

    /**
     * @param array $ids
     * @return ResponseCollection
     * @throws \Exception
     */
    public function getChannelsByIds(array $ids);

    /**
     * Search only videos in the channel
     *
     * @param  string $q
     * @param  string $channelId
     * @param  integer $maxResults
     * @param  string $order
     * @return ResponseCollection
     */
    public function searchChannelVideos($q, $channelId, $maxResults = 10, $order = null);

    /**
     * @param string $vId
     * @param int $maxResults
     * @param string|null $pageToken
     * @return ResponseCollection
     */
    public function getCommentThreads(string $vId, int $maxResults = 100, string $pageToken = null);
}