<?php

namespace App\Http\Controllers;

use App\Entities\Channel;

class ChannelController extends Controller
{
    /**
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Channel $channel)
    {
        $videos = $channel->videos()->latest()->paginate(3);

        $this->meta->setTitle($channel->name);

        return view('channel.show', compact('channel', 'videos'));
    }
}
