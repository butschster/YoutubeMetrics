<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentsCollection;
use Illuminate\Support\Facades\Cache;

class GetComments extends Controller
{
    /**
     * Получение списка всех комментариев канала
     *
     * @param Channel $channel
     * @return CommentsCollection
     */
    public function __invoke(Channel $channel): CommentsCollection
    {
        $cacheKey = md5('channel_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {
            return $channel->comments()
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) use ($channel) {
                    $comment->setRelation('channel', $channel);
                    return new CommentResource($comment);
                });
        });

        return new CommentsCollection($comments);
    }
}