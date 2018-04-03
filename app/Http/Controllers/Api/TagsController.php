<?php

namespace App\Http\Controllers\Api;

use App\Entities\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Http\Resources\VideoCollection;

class TagsController extends Controller
{
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
        return new VideoCollection($tag->videos()->with('channel')->latest()->get());
    }
}
