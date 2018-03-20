<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use App\Entities\Comment;
use App\Entities\Video;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CommentsController extends Controller
{
    /**
     * @param Video $video
     * @return array
     */
    public function index(Video $video)
    {
        $comments = Cache::remember("comments:".$video->id, now()->addHour(), function () use ($video) {
            return Comment::with('author')
                ->filterByVideo($video)
                ->where('total_likes', '>', 0)
                ->orderBy('total_likes', 'desc')
                ->latest()
                ->get()
                ->map(function ($comment) {
                    return $this->mapComment(
                        $comment,
                        $comment->author ?? new Author
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
     * @param Author $author
     * @return array
     */
    public function channel(Author $author)
    {
        $cacheKey = md5('author_comments'.$author->id);

        $comments = Cache::remember($cacheKey, now()->addHour(), function () use ($author) {

            return Comment::filterByChannel($author)->orderBy('total_likes', 'desc')->latest()
                ->get()
                ->map(function ($comment) use ($author) {
                    return $this->mapComment($comment, $author);
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
     * @param Author $author
     * @return array
     */
    protected function mapComment(Comment $comment, Author $author): array
    {
        return [
            'id' => $comment->id,
            'text' => $comment->text,
            'total_likes' => $comment->total_likes,
            'video_id' => $comment->video_id,
            'author_id' => $comment->channel_id,
            'author_type' => $author->type(),
            'author_name' => $author->name ?? $comment->channel_id,
            'created_at' => $comment->formatted_date,
        ];
    }
}
