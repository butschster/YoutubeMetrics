<?php

namespace App\Http\Controllers\Comment;

use App\Entities\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentsCollection;

class GetSpamCommentsForLastDay extends Controller
{
    /**
     * @return CommentsCollection
     */
    public function __invoke(): CommentsCollection
    {
        $comments = Comment::onlySpam()
            ->with('channel')->where('created_at', '>', now()->subDay())
            ->latest()
            ->paginate(100);

        return new CommentsCollection($comments);
    }
}