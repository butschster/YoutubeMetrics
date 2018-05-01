<?php

namespace App\Http\Controllers\Tag;

use App\Entities\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;

class Show extends Controller
{
    /**
     * @param Tag $tag
     * @return TagResource
     */
    public function __invoke(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }
}