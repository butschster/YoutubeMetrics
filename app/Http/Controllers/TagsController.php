<?php

namespace App\Http\Controllers;

use App\Entities\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Tag $tag)
    {
        $videos = $tag->videos()->latest()->paginate();

        return view('tag.show', compact('tag', 'videos'));
    }
}
