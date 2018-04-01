<?php

namespace App\Http\Controllers\Api\Channel;

use App\Entities\Channel;
use App\Entities\FollowedChannel;
use App\Http\Resources\Channel\ChannelCollection;
use App\Http\Resources\Channel\ChannelResource;
use App\Http\Resources\Video\VideoCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    /**
     * @param Channel $channel
     * @return ChannelResource
     */
    public function show(Channel $channel): ChannelResource
    {
        return new ChannelResource($channel);
    }

    /**
     * @param Channel $channel
     * @return ChannelResource
     */
    public function videos(Channel $channel): VideoCollection
    {
        return new VideoCollection($channel->videos()->with('channel')->latest()->paginate(3));
    }

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
}
