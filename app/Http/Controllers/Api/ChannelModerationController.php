<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelCollection;
use Illuminate\Support\Facades\Cache;

class ChannelModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Пометка канала ботом
     *
     * @param Channel $channel
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsBot(Channel $channel)
    {
        $this->authorize('moderate', $channel);

        $channel->markAsBot();

        $this->clearCache($channel);

        return ['status' => true];
    }

    /**
     * Пометка канала нормальным
     *
     * @param Channel $channel
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsNormal(Channel $channel)
    {
        $this->authorize('moderate', $channel);

        $channel->markAsNormal();

        $this->clearCache($channel);

        return ['status' => true];
    }

    /**
     * todo: возможно лишний метод, т.к. сброк кеша канала происходит при изменении данных
     *
     * @param Channel $channel
     */
    protected function clearCache(Channel $channel): void
    {
        Cache::forget(md5('channel'.$channel->id));
    }
}
