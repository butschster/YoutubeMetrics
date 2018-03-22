<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Http\Controllers\Controller;

class ChannelModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
