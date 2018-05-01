<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Domain\Channel\ChannelModerator;
use App\Entities\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModerateChannel extends Controller
{
    /**
     * Модерация канала.
     *
     * Необходимо передать статус канала (bot, normal, verified)
     *
     * @param ChannelRepository $repository
     * @param Request $request
     * @param Channel $channel
     * @return array
     * @throws \App\Domain\Channel\ChannelStatusNotFound
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(ChannelRepository $repository, Request $request, Channel $channel)
    {
        $this->authorize('moderate');

        $request->validate([
            'status' => [
                'required',
                Rule::in([Channel::TYPE_BOT, Channel::TYPE_NORMAL, Channel::TYPE_VERIFIED]),
            ]
        ]);

        (new ChannelModerator($repository, $request->user()->getKey()))
            ->setStatusForChannel($channel->id, $request->status);

        return ['status' => true];
    }
}