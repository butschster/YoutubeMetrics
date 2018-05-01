<?php

namespace App\Http\Controllers\Video;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoResource;

class Show extends Controller
{

    /**
     * @param Video $video
     * @return VideoResource
     */
    public function __invoke(Video $video): VideoResource
    {
        return new VideoResource($video->load('channel'));
    }
}