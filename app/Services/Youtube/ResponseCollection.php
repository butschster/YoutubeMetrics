<?php

namespace App\Services\Youtube;

use App\Contracts\Services\Youtube\Client as ClientContract;
use Illuminate\Support\Collection;

class ResponseCollection extends Collection
{
    /**
     * @var string
     */
    private $nextPageToken;

    /**
     * @var string
     */
    private $prevPageToken;

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return !is_null($this->nextPageToken);
    }

    /**
     * @return bool
     */
    public function hasPrevPage(): bool
    {
        return !is_null($this->prevPageToken);
    }

    /**
     * @return string
     */
    public function getNextPageToken(): ?string
    {
        return $this->nextPageToken;
    }

    /**
     * @return string
     */
    public function getPrevPageToken(): ?string
    {
        return $this->prevPageToken;
    }

    /**
     * @param string $nextPageToken
     */
    public function setNextPageToken(string $nextPageToken = null): void
    {
        $this->nextPageToken = $nextPageToken;
    }

    /**
     * @param string $prevPageToken
     */
    public function setPrevPageToken(string $prevPageToken = null): void
    {
        $this->prevPageToken = $prevPageToken;
    }

    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $collection = parent::map($callback);

        $collection->setNextPageToken($this->getNextPageToken());
        $collection->setPrevPageToken($this->getPrevPageToken());

        return $collection;
    }
}