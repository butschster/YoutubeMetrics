<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Entities\FollowedChannel;
use App\Http\Resources\ChannelCollection;
use Carbon\Carbon;
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

    /**
     * Получение списка каналов, не ботов, зарегистрированных в переданную дату
     *
     * @param string $date
     * @return ChannelCollection
     */
    public function filteredByDateCreation(string $date): ChannelCollection
    {
        $channels = Cache::remember(md5(__METHOD__.$date), now()->addHour(), function () use($date) {
            return Channel::filterBots()
                ->whereRaw('date(created_at) = ?')
                ->orderByDesc('total_comments')
                ->addBinding($date)
                ->get();
        });

        return new ChannelCollection(
            $channels
        );
    }
}
