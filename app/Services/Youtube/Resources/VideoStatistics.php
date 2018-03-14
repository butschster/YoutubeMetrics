<?php

namespace App\Services\Youtube\Resources;

use Illuminate\Contracts\Support\Arrayable;

class VideoStatistics implements Arrayable
{
    private $statistics;

    /**
     * @param $statistics
     */
    public function __construct($statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * @return int
     */
    public function getViewCount(): int
    {
        return $this->statistics->viewCount ?? 0;
    }

    /**
     * @return int
     */
    public function getLikeCount(): int
    {
        return $this->statistics->likeCount ?? 0;
    }

    /**
     * @return int
     */
    public function getDislikeCount(): int
    {
        return $this->statistics->dislikeCount ?? 0;
    }

    /**
     * @return int
     */
    public function getFavoriteCount(): int
    {
        return $this->statistics->favoriteCount ?? 0;
    }

    /**
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->statistics->commentCount ?? 0;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'views' => $this->getViewCount(),
            'likes' => $this->getLikeCount(),
            'dislikes' => $this->getDislikeCount(),
            'comments' => $this->getCommentCount(),
            'favorites' => $this->getFavoriteCount()
        ];
    }
}