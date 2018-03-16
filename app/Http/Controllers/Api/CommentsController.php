<?php

namespace App\Http\Controllers\Api;

use App\Entities\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * @param string $videoId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(string $videoId)
    {
        $comments = Comment::where('video_id', $videoId)->orderBy('total_likes', 'desc')->latest()->paginate(50);

        return $comments;
    }
}
