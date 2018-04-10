<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckChannel extends Controller
{
    /**
     * Проверка канала по ID на принадлежность к ботам
     *
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request): array
    {
        $request->validate(['channel_id' => 'required']);

        $id = $request->channel_id;

        $cacheKey = md5('channel.check.'.$id);

        $channelType = Cache::remember($cacheKey, now()->addHour(), function () use ($id) {
            return Channel::findOrFail($id)->type;
        });

        return ['type' => $channelType];
    }
}