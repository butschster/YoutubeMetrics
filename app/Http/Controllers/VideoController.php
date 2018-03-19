<?php

namespace App\Http\Controllers;

use App\Entities\Video;
use Illuminate\Http\Request;
use KodiCMS\Assets\Contracts\MetaInterface;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::with('channel')->latest()->paginate(9);

        return view('video.index', compact('videos'));
    }

    /**
     * @param Video $video
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $this->meta->setTitle($video->title);

        $tags = $video->tags->pluck('name');

        return view('video.show', compact('video', 'tags'));
    }
}
