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
        $this->statistics = new VideoStatistics($data->statistics);
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
    public function getStatistics(): VideoStatistics
    {
        return $this->statistics;
    }
}