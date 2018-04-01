<?php

namespace App\Http\Controllers\Api\Video;

use App\Entities\Video;
use App\Http\Resources\Video\VideoCollection;
use App\Http\Resources\Video\VideoResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * @return VideoCollection
     */
    public function index(): VideoCollection
    {
        $videos = Video::with('channel')
            ->latest()
            ->paginate(9);

        return new VideoCollection($videos);
    }

    /**
     * @param Video $video
     * @return VideoResource
     */
    public function show(Video $video): VideoResource
    {
        return new VideoResource($video->load('channel'));
    }
}
