<?php

namespace App\Http\Controllers\Api;

use App\Entities\{
    Channel, FollowedChannel
};
use App\Http\Resources\Channel\ChannelCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{

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
        $channels = Channel::filterBots()
            ->filterVerified()
            ->whereRaw('date(created_at) = ?')
            ->orderByDesc('total_comments')
            ->addBinding($date)
            ->get();

        return new ChannelCollection(
            $channels
        );
    }

    /**
     * Получение списка ботов, зарегистрированных в переданную дату
     *
     * @param string $date
     * @return ChannelCollection
     */
    public function botsFilteredByDateCreation(string $date): ChannelCollection
    {
        $channels = Channel::onlyBots()
            ->whereRaw('date(created_at) = ?')
            ->orderByDesc('total_comments')
            ->addBinding($date)
            ->get();

        return new ChannelCollection(
            $channels
        );
    }
}
