<?php

namespace App\Http\Controllers;

use App\Entities\{
    Tag, Video
};
use Illuminate\Support\Facades\Cache;

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

        $tags = $video->tags->pluck('link', 'name');

        $this->meta->setMetaKeywords($tags->keys()->all());
        $this->meta->setMetaDescription(str_limit($video->description, 255));

        $cacheKey = md5("spamComment".$video->id);
        $spamCommentsCount = Cache::remember($cacheKey, now()->addHour(), function () use ($video) {
            return $video->comments()->where('is_spam', true)->count();
        });

        return view('video.show', compact('video', 'tags', 'spamCommentsCount'));
    }

    /**
     * @param Tag $tag
     */
    public function byTag(Tag $tag)
    {

    }
}
