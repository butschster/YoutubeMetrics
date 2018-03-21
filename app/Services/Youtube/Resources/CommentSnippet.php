<?php

namespace App\Services\Youtube\Resources;

use Carbon\Carbon;

class CommentSnippet
{
    private $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return Carbon
     */
    public function getPublishedAt(): Carbon
    {
        return Carbon::parse($this->data->publishedAt);
    }

    /**
     * @return string
     */
    public function getAuthorDisplayName(): ?string
    {
        return $this->data->authorDisplayName;
    }

    /**
     * @return string
     */
    public function getAuthorChannelId(): ?string
    {
        return $this->data->authorChannelId->value;
    }

    /**
     * @return string
     */
    public function getVideoId(): ?string
    {
        return $this->data->videoId;
    }

    /**
     * @return string
     */
    public function getTextDisplay(): ?string
    {
        return $this->data->textDisplay;
    }

    /**
     * @return string
     */
    public function getTextOriginal(): ?string
    {
        return $this->data->textOriginal;
    }

    /**
     * @return bool
     */
    public function canRate(): bool
    {
        return $this->data->canRate;
    }

    /**
     * @return string
     */
    public function getViewerRating(): string
    {
        return $this->data->viewerRating;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->data->likeCount;
    }
}