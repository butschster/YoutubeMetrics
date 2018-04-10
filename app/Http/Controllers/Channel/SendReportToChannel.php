<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendReportToChannel extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Добавление жалобы на канал
     *
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $channel = Channel::firstOrNew(['id' => $request->channel_id]);

        $this->authorize('report', $channel);

        $channel->sendReport($request->user());

        return ['type' => $channel->type];
    }
}