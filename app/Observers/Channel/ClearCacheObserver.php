<?php

namespace App\Observers\Channel;

use App\Entities\Channel;
use Illuminate\Support\Facades\Cache;

class ClearCacheObserver
{
    /**
     * @param Channel $channel
     */
    public function saved(Channel $channel)
    {
        Cache::forget(md5('channel'.$channel->id));
    }
}