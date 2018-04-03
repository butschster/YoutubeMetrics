<?php

namespace App\Http\Controllers\Api\Video;

use App\Entities\Tag;
use App\Entities\Video;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagsCollection;
use App\Http\Resources\Video\VideoCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @param Video $video
     * @return TagsCollection
     */
    public function index(Video $video): TagsCollection
    {
        return new TagsCollection($video->tags);
    }

    /**
     * @param Tag $tag
     * @return TagResource
     */
    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    /**
     * @param Tag $tag
     * @return VideoCollection
     */
    public function videos(Tag $tag): VideoCollection
    {
        return new VideoCollection($tag->videos);
    }
}
