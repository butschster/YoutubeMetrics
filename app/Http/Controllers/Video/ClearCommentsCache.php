<?php

namespace App\Http\Controllers\Video;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ClearCommentsCache extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Сброс кеша комментариев
     *
     * @param Video $video
     */
    public function __invoke(Video $video)
    {
        Cache::forget(md5("comments:".$video->id));
        Cache::forget(md5("comments:bots:".$video->id));
    }
}