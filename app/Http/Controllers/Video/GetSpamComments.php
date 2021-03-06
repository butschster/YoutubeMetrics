<?php

namespace App\Http\Controllers\Video;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentsCollection;
use Illuminate\Support\Facades\Cache;

class GetSpamComments extends Controller
{
    /**
     * Получение комментариев от ботов к видео
     *
     * @param Video $video
     * @return CommentsCollection
     */
    public function __invoke(Video $video): CommentsCollection
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
                        $comment->setRelation('channel', $comment->channel ?? new Channel())
                    );
                });
        });

        return new CommentsCollection($comments);
    }
}