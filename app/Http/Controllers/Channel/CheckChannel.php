<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;

class CheckChannel extends Controller
{
    /**
     * Проверка канала по ID на принадлежность к ботам
     *
     * @param Request $request
     * @param ChannelRepository $repository
     * @return array
     */
    public function __invoke(Request $request, ChannelRepository $repository): array
    {
        $request->validate([
            'channel_id' => 'required'
        ]);

        return [
            'type' => $repository->getChannelType($request->channel_id)
        ];
    }
}