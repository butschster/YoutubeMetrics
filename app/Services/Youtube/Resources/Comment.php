<?php

namespace App\Services\Youtube\Resources;

class Comment
{
    protected $data;

    /**
     * @var CommentSnippet
     */
    private $snippet;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->snippet = new CommentSnippet($data->snippet->topLevelComment->snippet);
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
     * @return CommentSnippet
     */
    public function getSnippet(): CommentSnippet
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
}