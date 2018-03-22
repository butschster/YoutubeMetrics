<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Video;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CommentsController extends Controller
{
    /**
     * @param Video $video
     * @return array
     */
    public function video(Video $video)
    {
        $cacheKey = md5("comments:".$video->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($video) {
            return Comment::with('channel')
                ->filterByVideo($video)
                ->where('total_likes', '>', 0)
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function ($comment) {
                    return $this->mapComment(
                        $comment,
                        $comment->channel ?? new Channel
                    );
                })
                ->toArray();
        });

        return [
            'comments' => $comments,
            'total_comments' => $video->comments
        ];
    }

    /**
     * @param Video $video
     * @return array
     */
    public function videoSpam(Video $video)
    {
        $cacheKey = md5("comments:bots:".$video->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($video) {
            return Comment::with('channel')
                ->filterByVideo($video)
                ->onlySpam()
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function ($comment) {
                    return $this->mapComment(
                        $comment,
                        $comment->channel ?? new Channel
                    );
                })
                ->toArray();
        });

        return [
            'comments' => $comments,
            'total_comments' => $video->comments
        ];
    }

    /**
     * @param Channel $channel
     * @return array
     */
    public function channel(Channel $channel)
    {
        $cacheKey = md5('channel_comments'.$channel->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($channel) {

            return Comment::filterByChannel($channel)->orderBy('total_likes', 'desc')->latest()
                ->get()
                ->map(function ($comment) use ($channel) {
                    return $this->mapComment($comment, $channel);
                })
                ->toArray();

        });

        return [
            'comments' => $comments,
            'total_comments' => count($comments)
        ];
    }

    /**
     * @param Comment $comment
     * @param Channel $channel
     * @return array
     */
    protected function mapComment(Comment $comment, Channel $channel): array
    {
        return [
            'id' => $comment->id,
            'text' => $comment->text,
            'total_likes' => $comment->total_likes,
            'video_id' => $comment->video_id,
            'channel_id' => $comment->channel_id,
            'channel_type' => $channel->type(),
            'channel_name' => $channel->name ?? $comment->channel_id,
            'created_at' => $comment->formatted_date,
        ];
    }
}
