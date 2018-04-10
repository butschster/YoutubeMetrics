<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Resources\Channel\ChannelResource;
use App\Http\Controllers\Controller;

class Show extends Controller
{
    /**
     * @param Channel $channel
     * @return ChannelResource
     */
    public function __invoke(Channel $channel): ChannelResource
    {
        return new ChannelResource($channel);
    }
}
