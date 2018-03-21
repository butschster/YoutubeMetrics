<?php

namespace App\Services\Youtube\Resources;

class Video
{
    protected $data;

    /**
     * @var VideoSnippet
     */
    protected $snippet;

    /**
     * @var VideoStatistics
     */
    protected $statistics;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->snippet = new VideoSnippet($data->snippet);

        if (isset($data->statistics)) {
            $this->statistics = new VideoStatistics($data->statistics);
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data->{$key};
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->data->id;
    }

    /**
     * @return VideoSnippet
     */
    public function getSnippet(): VideoSnippet
    {
        return $this->snippet;
    }

    /**
     * @return string
     */
    public function getEtag(): string
    {
        return $this->data->etag ?? null;
    }

    /**
     * @return VideoStatistics
     */
    public function getStatistics(): ?VideoStatistics
    {
        return $this->statistics;
    }

    /**
     * @return bool
     */
    public function hasStatistics(): bool
    {
        return !empty($this->statistics);
    }
}