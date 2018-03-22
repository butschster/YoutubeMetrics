<?php

namespace App\Observers\Channel;

use App\Entities\Channel;
use Illuminate\Contracts\Cache\Repository;

class ClearCacheObserver
{
    /**
     * @var Repository
     */
    private $cache;

    /**
     * @param Repository $cache
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param Channel $channel
     */
    public function saved(Channel $channel)
    {
        $this->cache->forget(md5('channel'.$channel->id));
    }
}