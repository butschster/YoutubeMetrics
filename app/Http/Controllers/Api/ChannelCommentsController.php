<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsCollection;
use Illuminate\Support\Facades\Cache;

class ChannelCommentsController extends Controller
{
    /**
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
