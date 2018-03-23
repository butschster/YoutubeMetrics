<?php

namespace App\Contracts\Services\Youtube;

use App\Services\Youtube\Resources\{
    Channel, Comment, Video
};
use App\Services\Youtube\ResponseCollection;
use App\Services\Youtube\ResponseException;
use GuzzleHttp\ClientInterface;

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
     * @param array $optionalParams
     * @return Channel
     */
    public function getChannelById($id, $optionalParams = false);

    /**
     * @param $username
     * @param array $optionalParams
     * @return Channel
     * @throws \Exception
     */
    public function getChannelByName($username, $optionalParams = false);

    /**
     * @param array $ids
     * @param array $optionalParams
     * @return ResponseCollection|Channel[]
     */
    public function getChannelsById($ids = array(), $optionalParams = false);

    /**
     * @param string $vId
     * @param int $maxResults
     * @param string|null $pageToken
     * @return ResponseCollection|Comment[]
     */
    public function getCommentThreads(string $vId, int $maxResults = 100, string $pageToken = null);

    /**
     * Search only videos in the channel
     *
     * @param  string $q
     * @param  string $channelId
     * @param  integer $maxResults
     * @param  string $order
     * @return ResponseCollection|Video[]
     */
    public function searchChannelVideos($q, $channelId, $maxResults = 10, $order = null);

    /**
     * Search only videos
     *
     * @param  string $q Query
     * @param  integer $maxResults number of results to return
     * @param  string $order Order by
     * @return ResponseCollection|Video[]
     */
    public function searchVideos($q, $maxResults = 10, $order = null);

    /**
     * @param ClientInterface $client
     */
    public function setHttpClient(ClientInterface $client);
}