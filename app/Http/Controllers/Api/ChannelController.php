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
     * @param Request $request
     * @return array
     */
    public function check(Request $request): array
    {
        $request->validate(['channel_id' => 'required']);

        $id = $request->channel_id;

        $cacheKey = md5('channel'.$id);

        $channel = Cache::remember($cacheKey, now()->addHour(), function () use ($id) {
            return Channel::live()->find($id);
        });

        return [
            'type' => !is_null($channel) ? $channel->type : 'normal'
        ];
    }

    /**
     * @return ChannelCollection
     */
    public function reported(): ChannelCollection
    {
        return new ChannelCollection(
            Channel::onlyReported()->live()->get()
        );
    }

    /**
     * @return ChannelCollection
     */
    public function bots(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember('bots', now()->addHour(), function () {
                return Channel::onlyBots()->live()->orderBy('total_comments')->get();
            })
        );
    }
}
