<?php

namespace App\Services\Youtube\Resources;

use Carbon\Carbon;

class ChannelSnippet
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
    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->data->country ?? 'RU';
    }

    /**
     * @return string
     */
    public function getThumb(): ?string
    {
        return $this->data->thumbnails->medium->url ?? null;
    }
}