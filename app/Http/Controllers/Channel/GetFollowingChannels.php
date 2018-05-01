<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;

class GetFollowingChannels extends Controller
{
    /**
     * Получение списка каналов, за которыми производится слежение
     *
     * @param ChannelRepository $repository
     * @return ChannelCollection
     */
    public function __invoke(ChannelRepository $repository): ChannelCollection
    {
        return new ChannelCollection(
            $repository->getFollowingChannels()
        );
    }
}