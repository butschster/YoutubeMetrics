<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Http\Resources\Channel\ChannelCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelReportController extends Controller
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
    public function index(): ChannelCollection
    {
        return new ChannelCollection(
            Channel::onlyReported()->live()->get()
        );
    }

    /**
     * Добавление жалобы на канал
     *
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $channel = Channel::firstOrNew(['id' => $request->channel_id]);

        $this->authorize('report', $channel);

        $channel->sendReport($request->user());

        return ['type' => $channel->type];
    }
}
