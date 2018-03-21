<?php

namespace App\Services\Youtube\Resources;

use Illuminate\Contracts\Support\Arrayable;

class ChannelStatistics implements Arrayable
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
    public function getSubscriberCount(): int
    {
        return $this->statistics->subscriberCount ?? 0;
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
            'subscribers' => $this->getSubscriberCount(),
            'comments' => $this->getCommentCount(),
        ];
    }
}