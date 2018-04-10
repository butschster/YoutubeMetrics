<?php

namespace App\Http\Controllers\Comment;

use App\Entities\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;

class Show extends Controller
{
    /**
     * @param Comment $comment
     * @return CommentResource
     */
    public function __invoke(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }
}