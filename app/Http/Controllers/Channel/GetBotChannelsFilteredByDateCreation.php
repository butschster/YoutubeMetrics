<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;

class GetBotChannelsFilteredByDateCreation extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Получение списка ботов, зарегистрированных в переданную дату
     *
     * @param string $date
     * @return ChannelCollection
     */
    public function __invoke(string $date): ChannelCollection
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