<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Http\Controllers\Controller;

class GetBotChannelsGroupedByCreationDate extends Controller
{
    /**
     * @param ChannelRepository $repository
     * @return array
     */
    public function __invoke(ChannelRepository $repository)
    {
        return ['bots' => $repository->getChannelsGroupedByCreationDate()];
    }
}