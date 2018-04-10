<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;

class GetReportedChannels extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Получение списка каналов, которые имеют жалобы, но еще не боты
     *
     * @return ChannelCollection
     */
    public function __invoke(): ChannelCollection
    {
        return new ChannelCollection(
            Channel::onlyReported()->live()->get()
        );
    }
}