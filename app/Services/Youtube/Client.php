<?php

namespace App\Services\Youtube;

use App\Contracts\Services\Youtube\Client as ClientContract;
use App\Services\Youtube\Resources\Video;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Madcoda\Youtube\Youtube;

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
     * Using CURL to issue a GET request
     *
     * @param string $url
     * @param array $params
     * @return string
     */
    public function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = $this->youtube_key;

        $response = (new \GuzzleHttp\Client)->get($url, ['query' => $params]);

        return $response->getBody()->getContents();
    }

    /**
     * @param string $vId
     * @param int $maxResults
     * @param string|null $pageToken
     * @return ResponseCollection
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

        return $this->decodeList(
            $data
        );
    }

    /**
     * @param array $ids
     * @return ResponseCollection
     * @throws \Exception
     */
    public function getChannelsByIds(array $ids)
    {
        $API_URL = $this->getApi('channels.list');

        $params = array(
            'id' => implode(',', $ids),
            'part' => 'id,snippet,contentDetails,statistics,invideoPromotion',
            'maxResults' => 50
        );

        $apiData = $this->api_get($API_URL, $params);
        return $this->decodeList($apiData);
    }

    /**
     * @param string $id
     * @return Resources\Video
     * @throws ResponseException
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
     * @param  string $apiData the api response from youtube
     * @throws ResponseException
     * @return \StdClass  an Youtube resource object
     */
    public function decodeSingle(&$apiData)
    {
        $resObj = $this->deserializeResponse($apiData);

        if (isset($resObj->error)) {
            $this->raiseResponseError($resObj->error);
        }

        $itemsArray = $resObj->items;
        if (!is_array($itemsArray) || count($itemsArray) == 0) {
            return false;
        }

        return $itemsArray[0];
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

        return new ResponseCollection(
            $resObj->items ?? [],
            $resObj->nextPageToken ?? null,
            $resObj->prevPageToken ?? null
        );
    }

    /**
     * @param $error
     * @throws ResponseException
     */
    protected function raiseResponseError($error): void
    {
        $msg = $error->message;

        throw new ResponseException(
            $msg,
            $error->code,
            $error->errors ?? []
        );
    }

    /**
     * @param $apiData
     * @return \stdClass
     */
    protected function deserializeResponse(string $apiData)
    {
        return \GuzzleHttp\json_decode($apiData);
    }
}