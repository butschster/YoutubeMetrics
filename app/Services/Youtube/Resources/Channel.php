<?php

namespace App\Services\Youtube\Resources;

class Channel
{
    protected $data;

    /**
     * @var ChannelSnippet
     */
    private $snippet;

    /**
     * @var ChannelStatistics
     */
    private $statistics;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->snippet = new ChannelSnippet($data->snippet);
        if (isset($data->statistics)) {
            $this->statistics = new ChannelStatistics($data->statistics);
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
     * @return ChannelSnippet
     */
    public function getSnippet(): ChannelSnippet
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
     * @return ChannelStatistics
     */
    public function getStatistics(): ChannelStatistics
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