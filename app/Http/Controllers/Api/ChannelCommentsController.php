<?php

namespace App\Http\Controllers\Api;

use App\Entities\{
    Channel, Comment
};
use App\Http\Resources\Comment\{
    CommentResource, CommentsCollection
};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelCommentsController extends Controller
{
    /**
     * Получение списка всех комментариев канала
     *
     * @param Channel $channel
     * @return CommentsCollection
     */
    public function index(Channel $channel): CommentsCollection
    {
        $cacheKey = md5('channel_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {
            return $channel->comments()
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) use($channel) {
                    $comment->setRelation('channel', $channel);

                    return new CommentResource($comment);
                });
        });

        return new CommentsCollection($comments);
    }

    /**
     * Получение списка всех комментариев канала, написанных ботами
     *
     * @param Channel $channel
     * @return CommentsCollection
     */
    public function fromBots(Channel $channel): CommentsCollection
    {
        $cacheKey = md5('channel_bots_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {
            return $channel
                ->videoComments()
                ->with('channel')
                ->onlySpam()
                ->get()
                ->map(function($comment) {
                    return new CommentResource($comment);
                });
        });

        return new CommentsCollection($comments);
    }
}
