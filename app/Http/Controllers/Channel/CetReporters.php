<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelReportCollection;

class CetReporters extends Controller
{
    /**
     * Получение списка людей, отправивших жалобу на канал
     *
     * @param ChannelRepository $repository
     * @param Channel $channel
     * @return ChannelReportCollection
     */
    public function __invoke(ChannelRepository $repository, Channel $channel): ChannelReportCollection
    {
        return new ChannelReportCollection(
            $repository->getReportersForChannel($channel->id)
        );
    }
}