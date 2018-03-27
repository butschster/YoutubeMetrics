<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelVerificationController extends Controller
{
    /**
     * Проверка канала по ID на принадлежность к ботам
     *
     * @param Request $request
     * @return array
     */
    public function check(Request $request): array
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
