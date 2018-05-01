<?php

namespace App\Http\Controllers\Tag;

use App\Entities\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoCollection;

class GetVideos extends Controller
{
    /**
     * @param Tag $tag
     * @return VideoCollection
     */
    public function __invoke(Tag $tag): VideoCollection
    {
        return new VideoCollection($tag->videos);
    }
}