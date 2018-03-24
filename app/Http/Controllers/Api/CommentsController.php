<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentsCollection;
use Illuminate\Support\Facades\Cache;

class CommentsController extends Controller
{
    public function cacheClear(Video $video)
    {
        Cache::forget(md5("comments:".$video->id));
        Cache::forget(md5("comments:bots:".$video->id));
    }

    /**
     * @param Video $video
     * @return CommentsCollection
     */
    public function video(Video $video): CommentsCollection
    {
        $cacheKey = md5("comments:".$video->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($video) {
            return Comment::with('channel')
                ->filterByVideo($video)
                ->where('total_likes', '>', 0)
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) {
                    return new CommentResource(
                        $comment->setRelation('channel', $comment->channel ?? new Channel)
                    );
                });
        });

        return new CommentsCollection($comments);
    }

    /**
     * @param Video $video
     * @return CommentsCollection
     */
    public function videoSpam(Video $video): CommentsCollection
    {
        $cacheKey = md5("comments:bots:".$video->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($video) {
            return Comment::with('channel')
                ->filterByVideo($video)
                ->onlySpam()
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) {
                    return new CommentResource(
                        $comment->setRelation('channel', $comment->channel ?? new Channel)
                    );
                });
        });

        return new CommentsCollection($comments);
    }

    /**
     * @param Channel $channel
     * @return array
     */
    public function channel(Channel $channel)
    {
        $cacheKey = md5('channel_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {
            return $channel->comments()->with('channel')
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function (Comment $comment) {
                    return new CommentResource($comment);
                });
        });


        return (new CommentsCollection($comments))->additional([
            'total_comments' => count($comments)
        ]);
    }
}
