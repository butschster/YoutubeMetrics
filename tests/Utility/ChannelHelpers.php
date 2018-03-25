<?php

namespace Tests\Utility;

use App\Entities\{
    Channel, FollowedChannel
};
use Illuminate\Support\Facades\Cache;

trait ChannelHelpers
{
    /**
     * Create a new followed channel
     *
     * @param array $attributes
     * @param int $times
     * @return FollowedChannel
     */
    public function createFollowedChannel(array $attributes = [], int $times = null)
    {
        return factory(FollowedChannel::class, $times)->create($attributes);
    }

    /**
     * Make a new followed channel
     *
     * @param array $attributes
     * @param int $times
     * @return FollowedChannel
     */
    public function makeFollowedChannel(array $attributes = [], int $times = null)
    {
        return factory(FollowedChannel::class, $times)->make($attributes);
    }

    /**
     * Create a new channel
     *
     * @param array $attributes
     * @param int $times
     * @return Channel
     */
    public function createChannel(array $attributes = [], int $times = null)
    {
        return factory(Channel::class, $times)->create($attributes);
    }

    /**
     * Make a new channel
     *
     * @param array $attributes
     * @param int $times
     * @return Channel
     */
    public function makeChannel(array $attributes = [], int $times = null)
    {
        return factory(Channel::class, $times)->make($attributes);
    }

    /**
     * @param string $channelId
     * @param int $times
     * @return $this
     */
    protected function shouldChannelCacheClear(string $channelId, int $times = 1)
    {
        Cache::shouldReceive('forget')->times($times)->with(md5('channel'.$channelId));

        return $this;
    }
}