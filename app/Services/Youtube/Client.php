<?php

namespace App\Services\Youtube;

use App\Contracts\Services\Youtube\Client as ClientContract;
use App\Exceptions\Youtube\NotFoundException;
use App\Services\Youtube\Resources\Channel;
use App\Services\Youtube\Resources\Comment;
use App\Services\Youtube\Resources\Video;
use GuzzleHttp\Exception\ClientException;
use Madcoda\Youtube\Youtube;
use Throwable;

class Client extends Youtube implements ClientContract
{
    /**
     * @var array
     */
    var $APIs = array(
        'videos.list' => 'https://www.googleapis.com/youtube/v3/videos',
        'search.list' => 'https://www.googleapis.com/youtube/v3/search',
        'channels.list' => 'https://www.googleapis.com/youtube/v3/channels',
        'playlists.list' => 'https://www.googleapis.com/youtube/v3/playlists',
        'playlistItems.list' => 'https://www.googleapis.com/youtube/v3/playlistItems',
        'activities' => 'https://www.googleapis.com/youtube/v3/activities',
        'comment.threads' => 'https://www.googleapis.com/youtube/v3/commentThreads',
    );

    /**
     * @param string $vId
     * @param int $maxResults
     * @param string|null $pageToken
     * @return ResponseCollection|Comment[]
     * @throws \Exception
     */
    public function getCommentThreads(string $vId, int $maxResults = 100, string $pageToken = null)
    {
        $API_URL = $this->getApi('comment.threads');
        $params = array(
            'videoId' => $vId,
            'part' => 'id, snippet',
            'maxResults' => $maxResults
        );

        if ($pageToken) {
            $params['pageToken'] = $pageToken;
        }

        $data = $this->api_get($API_URL, $params);

        return $this->decodeList($data)->map(function ($data) {
            return new Comment($data);
        });
    }

    /**
     * @param array $ids
     * @param array $optionalParams
     * @return Channel[]|ResponseCollection
     * @throws \Exception
     */
    public function getChannelsById($ids = array(), $optionalParams = false)
    {
        return parent::getChannelsById($ids, $optionalParams)->map(function ($data) {
            return new Channel($data);
        });
    }

    /**
     * @param $username
     * @param bool $optionalParams
     * @return Channel
     * @throws \Exception
     */
    public function getChannelByName($username, $optionalParams = false)
    {
        return new Channel(
            parent::getChannelByName($username, $optionalParams)
        );
    }

    /**
     * @param $id
     * @param bool $optionalParams
     * @return Channel
     * @throws \Exception
     */
    public function getChannelById($id, $optionalParams = false)
    {
        return new Channel(
            parent::getChannelById($id, $optionalParams)
        );
    }

    /**
     * @param string $id
     * @return Resources\Video
     * @throws \Exception
     */
    public function getVideoInfo($id)
    {
        return new Video(
            parent::getVideoInfo($id)
        );
    }

    /**
     * Decode the response from youtube, extract the single resource object.
     * (Don't use this to decode the response containing list of objects)
     *
     * @param string $apiData the api response from youtube
     * @throws ResponseException
     * @return \StdClass an Youtube resource object
     * @throws NotFoundException
     */
    public function decodeSingle(&$apiData)
    {
        $resObj = $this->deserializeResponse($apiData);

        if (isset($resObj->error)) {
            $this->raiseResponseError($resObj->error);
        }

        $itemsArray = $resObj->items;
        if (!is_array($itemsArray) || count($itemsArray) == 0) {
            throw new NotFoundException();
        }

        return $itemsArray[0];
    }

    /**
     * Search only videos in the channel
     *
     * @param  string $q
     * @param  string $channelId
     * @param  integer $maxResults
     * @param  string $order
     * @return ResponseCollection|Video[]
     */
    public function searchChannelVideos($q, $channelId, $maxResults = 10, $order = null)
    {
        return parent::searchChannelVideos($q, $channelId, $maxResults, $order)->map(function ($data) {
            return new Video($data);
        });
    }

    /**
     * Search only videos
     *
     * @param  string $q Query
     * @param  integer $maxResults number of results to return
     * @param  string $order Order by
     * @return ResponseCollection|Video[]
     */
    public function searchVideos($q, $maxResults = 10, $order = null)
    {
        return parent::searchChannelVideos($q, $maxResults, $order)->map(function ($data) {
            return new Video($data);
        });
    }

    /**
     * Decode the response from youtube, extract the list of resource objects
     *
     * @param  string $apiData response string from youtube
     * @throws \Exception
     * @return ResponseCollection
     */
    public function decodeList(&$apiData)
    {
        $resObj = $this->deserializeResponse($apiData);

        if (isset($resObj->error)) {
            $this->raiseResponseError($resObj->error);
        }

        $collection = new ResponseCollection($resObj->items ?? []);
        $collection->setNextPageToken($resObj->nextPageToken ?? null);
        $collection->setPrevPageToken($resObj->prevPageToken ?? null);

        return $collection;
    }

    /**
     * @param $error
     * @param Throwable|null $previous
     * @throws ResponseException
     */
    protected function raiseResponseError($error, Throwable $previous = null): void
    {
        $msg = $error->message;

        $exception = new ResponseException(
            $msg,
            $error->code,
            $previous
        );

        $exception->setErrors($error->errors ?? []);

        throw $exception;
    }

    /**
     * @param $apiData
     * @return \stdClass
     */
    protected function deserializeResponse(string $apiData)
    {
        return \GuzzleHttp\json_decode($apiData);
    }

    /**
     * Using CURL to issue a GET request
     *
     * @param string $url
     * @param array $params
     * @return string
     * @throws ResponseException
     */
    public function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = $this->youtube_key;

        try {
            $response = (new \GuzzleHttp\Client)->get($url, ['query' => $params]);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $response = $this->deserializeResponse($response->getBody()->getContents());

                if (isset($response->error)) {
                    $this->raiseResponseError($response->error, $e);
                }
            }

            throw $e;
        }

        return $response->getBody()->getContents();
    }
}