<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelCollection;

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
     */
    public function markAsBot(Channel $channel)
    {
        $channel->markAsBot();

        return ['status' => true];
    }

    /**
     * @param Channel $channel
     * @return array
     */
    public function markAsNormal(Channel $channel)
    {
        $channel->reports = 0;
        $channel->save();

        return ['status' => true];
    }
}
