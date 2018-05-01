<?php

namespace App\Http\Controllers\Video;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsCollection;

class GetTags extends Controller
{
    /**
     * @param Video $video
     * @return TagsCollection
     */
    public function __invoke(Video $video): TagsCollection
    {
        return new TagsCollection($video->tags);
    }
}