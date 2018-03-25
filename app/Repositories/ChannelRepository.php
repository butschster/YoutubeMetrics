<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChannelRepository as ChannelRepositoryContract;
use App\Entities\Channel;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class ChannelRepository extends Repository implements ChannelRepositoryContract
{
    /**
     * @var CacheContract
     */
    protected $cache;

    /**
     * @param CacheContract $cache
     * @param Channel $channel
     */
    public function __construct(CacheContract $cache, Channel $channel)
    {
        $this->cache = $cache;
        parent::__construct($channel);
    }

    /**
     * @param int|string $id
     * @return Channel
     */
    public function show($id): Channel
    {
        return $this->cache()->remember($this->geChannelCacheKey($id), now()->addHour(), function () use ($id) {
            return parent::show($id);
        });
    }

    /**
     * @param string|Channel $id
     * @return string
     */
    public function geChannelCacheKey($id): string
    {
        if ($id instanceof Channel) {
            $id = $id->getKey();
        }

        return md5('channel'.$id);
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return ['channels'];
    }

    /**
     * @return mixed
     */
    protected function cache()
    {
        return $this->cache->tags($this->getTags());
    }
}