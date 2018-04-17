<?php

namespace App\Repositories;

use Illuminate\Contracts\Cache\Repository as CacheContract;

trait Cacheable
{
    /**
     * @var CacheContract
     */
    protected $cache;

    /**
     * @param CacheContract $repository
     */
    protected function setCacheRepository(CacheContract $repository)
    {
        $this->cache = $repository;
    }

    /**
     * @return array
     */
    abstract public function cacheTags(): array;

    /**
     * @return mixed
     */
    protected function cache()
    {
        return $this->cache->tags($this->cacheTags());
    }
}