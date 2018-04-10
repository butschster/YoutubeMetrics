<?php

namespace App\Http\Controllers\Video;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoCollection;

class GetList extends Controller
{
    /**
     * @return VideoCollection
     */
    public function __invoke(): VideoCollection
    {
        $videos = Video::with('channel')
            ->latest()
            ->paginate(9);

        return new VideoCollection($videos);
    }
}