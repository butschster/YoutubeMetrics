<?php

namespace App\Services\Youtube\Resources;

use Carbon\Carbon;

class VideoSnippet
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
    public function getTitle(): ?string
    {
        return $this->data->title ?? null;
    }

    /**
     * @return string
     */
    public function getThumb(): ?string
    {
        return $this->data->thumbnails->high->url ?? null;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }

    /**
     * @return string
     */
    public function getChannelId(): ?string
    {
        return $this->data->channelId ?? null;
    }

    /**
     * @return string
     */
    public function getChannelTitle(): ?string
    {
        return $this->data->channelTitle ?? null;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->data->tags ?? [];
    }

    /**
     * @return bool
     */
    public function isUpcoming(): bool
    {
        return $this->data->liveBroadcastContent == 'upcoming';
    }

    /**
     * @param string $tag
     *
     * @return bool
     */
    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->getTags());
    }
}