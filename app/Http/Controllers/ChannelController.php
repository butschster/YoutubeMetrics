<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Author $author)
    {
        $videos = $author->videos()->latest()->paginate(3);

        $this->meta->setTitle($author->name);

        return view('channel.show', compact('author', 'videos'));
    }
}
