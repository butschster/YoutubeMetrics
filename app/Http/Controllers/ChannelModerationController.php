<?php

namespace App\Http\Controllers;

use App\Entities\Channel;

class ChannelModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('moderate', new Channel);

        return view('channel.moderation');
    }
}
