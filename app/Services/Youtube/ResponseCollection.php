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
     * @param array $items
     * @param string|null $nextPageToken
     * @param string|null $prevPageToken
     */
    public function __construct(array $items = [], string $nextPageToken = null, string $prevPageToken = null)
    {
        parent::__construct($items);

        $this->nextPageToken = $nextPageToken;
        $this->prevPageToken = $prevPageToken;
    }

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
    public function getNextPageToken(): string
    {
        return $this->nextPageToken;
    }

    /**
     * @return string
     */
    public function getPrevPageToken(): string
    {
        return $this->prevPageToken;
    }
}