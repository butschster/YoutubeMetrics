<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChannelCollection;
use Carbon\Carbon;

class GetChannelsFilteredByDateCreation extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Получение списка каналов, не верифицированных и не ботов, зарегистрированных в переданную дату
     *
     * @param ChannelRepository $repository
     * @param string $date
     * @return ChannelCollection
     */
    public function __invoke(ChannelRepository $repository, string $date): ChannelCollection
    {
        return new ChannelCollection(
            $repository->getNonBotChannelsRegisteredAt(Carbon::parse($date))
        );
    }
}