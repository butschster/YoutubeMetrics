<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;
use Illuminate\Support\Facades\Cache;

class GetBotChannels extends Controller
{
    /**
     * Получение полного списка каналов ботов.
     *
     * @return ChannelCollection
     */
    public function __invoke(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember(md5('channel.bot.list'), now()->addHour(), function () {
                return Channel::onlyBots()->live()->orderBy('total_comments')->get();
            })
        );
    }
}