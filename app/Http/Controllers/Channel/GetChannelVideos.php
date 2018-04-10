<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoCollection;

class GetChannelVideos extends Controller
{
    /**
     * Список видео канала
     *
     * @param Channel $channel
     * @return VideoCollection
     */
    public function __invoke(Channel $channel): VideoCollection
    {
        return new VideoCollection($channel->videos()->with('channel')->latest()->paginate(3));
    }
}