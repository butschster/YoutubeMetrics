<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
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
     * @param ChannelRepository $repository
     * @return ChannelCollection
     */
    public function __invoke(ChannelRepository $repository): ChannelCollection
    {
        return new ChannelCollection(
            $repository->getReportedChannels()
        );
    }
}