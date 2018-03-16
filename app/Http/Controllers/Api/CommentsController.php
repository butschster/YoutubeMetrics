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
     * @param string $videoId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(string $videoId)
    {
        $video = Video::findOrFail($videoId);

        $authors = $this->getAuthors();

        $comments = Cache::remember("comments:".$videoId, now()->addHour(), function () use ($videoId, $authors) {
            return Comment::where('video_id', $videoId)->where('total_likes', '>', 0)->orderBy('total_likes', 'desc')->latest()
                ->get()
                ->map(function ($comment) use ($authors) {

                    return $this->mapComment(
                        $comment,
                        $authors->get($comment->author_id, new Author)
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
    public function author(Author $author)
    {
        $comments = Cache::remember("author_comments:".$author->id, now()->addHour(), function () use ($author) {
            return Comment::where('author_id', $author->id)->orderBy('total_likes', 'desc')->latest()
                ->get()
                ->map(function ($comment) use($author) {
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
            'id' => $comment->comment_id,
            'text' => $comment->text,
            'total_likes' => $comment->total_likes,
            'video_id' => $comment->video_id,
            'author_id' => $comment->author_id,
            'author_type' => $author->type(),
            'created_at' => $comment->created_at->format('d.m.Y H:i:s'),
        ];
    }

    /**
     * @return Collection
     */
    protected function getAuthors(): Collection
    {
        return Cache::remember("authors", now()->addHour(), function () {
            return Author::live()->get(['id', 'reports', 'bot'])->pluck(null, 'id');
        });
    }
}
