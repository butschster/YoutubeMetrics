<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;

class GetBotChannels extends Controller
{
    /**
     * Получение полного списка каналов ботов.
     *
     * @return ChannelCollection
     */
    public function __invoke(ChannelRepository $repository): ChannelCollection
    {
        return new ChannelCollection(
            $repository->getBotChannels()
        );
    }
}