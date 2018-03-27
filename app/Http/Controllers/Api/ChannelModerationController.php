<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Events\Channel\Moderated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChannelModerationController extends Controller
{
    /**
     * Модерация канала.
     *
     * Необходимо передать статус канала (bot, normal, verified)
     *
     * @param Request $request
     * @param Channel $channel
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function moderate(Request $request, Channel $channel)
    {
        $this->authorize('moderate');

        $request->validate([
            'status' => [
                'required',
                Rule::in(['bot', 'normal', 'verified']),
            ]
        ]);

        $methodName = 'markAs'.ucfirst($request->status);

        $channel->$methodName(
            $request->user()
        );

        return ['status' => true];
    }
}
