<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Domain\Channel\ChannelReporter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendReportToChannel extends Controller
{
    /**
     * Добавление жалобы на канал
     *
     * @param Request $request
     * @param ChannelRepository $repository
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \App\Repositories\ChannelReportedException
     */
    public function __invoke(Request $request, ChannelRepository $repository)
    {
        $request->validate(['channel_id' => 'required']);

        $channel = $repository->show($request->channel_id);
        $this->authorize('report', $channel);

        $reported = new ChannelReporter($repository, $request->user()->getKey());
        $reported->sendReportToChannel($request->channel_id);

        return ['type' => $repository->getChannelType($request->channel_id)];
    }
}