<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Entities\FollowedChannel;
use App\Http\Resources\ChannelCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    /**
     * Получение списка каналов, за которыми производится слежение
     *
     * @return ChannelCollection
     */
    public function followed(): ChannelCollection
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

    /**
     * Получение полного списка каналов ботов.
     *
     * @return ChannelCollection
     */
    public function botList(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember(md5('channel.bot.list'), now()->addHour(), function () {
                return Channel::onlyBots()->live()->orderBy('total_comments')->get();
            })
        );
    }
}
