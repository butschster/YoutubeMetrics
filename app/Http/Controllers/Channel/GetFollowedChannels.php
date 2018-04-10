<?php

namespace App\Http\Controllers\Channel;

use App\Entities\FollowedChannel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;
use Illuminate\Support\Facades\Cache;

class GetFollowedChannels extends Controller
{
    /**
     * Получение списка каналов, за которыми производится слежение
     *
     * @return ChannelCollection
     */
    public function __invoke(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember('following-channels', now()->addHour(), function () {
                return FollowedChannel::with('channel')->whereHas('channel')->get()
                    ->map(function (FollowedChannel $channel) {
                        return $channel->channel;
                    })
                    ->sortByDesc('subscribers');
            })
        );
    }
}