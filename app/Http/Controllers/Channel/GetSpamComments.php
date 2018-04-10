<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentsCollection;
use Illuminate\Support\Facades\Cache;

class GetSpamComments extends Controller
{

    /**
     * Получение списка всех комментариев канала, написанных ботами
     *
     * @param Channel $channel
     * @return CommentsCollection
     */
    public function __invoke(Channel $channel): CommentsCollection
    {
        $cacheKey = md5('channel_bots_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {
            return Comment::join('videos', 'videos.id', '=', 'comments.video_id')
                ->where('videos.channel_id', $channel->id)
                ->onlySpam()
                ->with('channel')
                ->get(['comments.*'])
                ->map(function ($comment) {
                    return new CommentResource($comment);
                });
        });

        return new CommentsCollection($comments);
    }
}