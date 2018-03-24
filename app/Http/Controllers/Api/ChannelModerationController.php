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
     * @return ChannelCollection
     */
    public function index(): ChannelCollection
    {
        return new ChannelCollection(
            Channel::onlyReported()->live()->get()
        );
    }

    /**
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
     * @param Channel $channel
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsNormal(Channel $channel)
    {
        $this->authorize('moderate', $channel);

        $channel->reports = 0;
        $channel->bot = false;
        $channel->save();

        $this->clearCache($channel);

        return ['status' => true];
    }

    /**
     * @param Channel $channel
     */
    protected function clearCache(Channel $channel): void
    {
        Cache::forget(md5('channel'.$channel->id));
    }
}
