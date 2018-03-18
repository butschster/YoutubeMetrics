<?php

namespace App\Http\Controllers\Api;

use App\Entities\Comment;
use App\Entities\CommentLike;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CommentMetricsController extends Controller
{
    /**
     * @param Comment $comment
     * @return mixed
     */
    public function index(Comment $comment)
    {
        return Cache::remember("comment_stat:".$comment->id, now()->addMinutes(5), function () use ($comment) {
            return $this->prepareData(
                CommentLike::where('comment_id', $comment->id)->oldest()->get()
            );
        });
    }

    /**
     * @param $result
     * @return array
     */
    protected function prepareData($result): array
    {
        $data = [
            'likes' => [
                'name' => 'Лайки',
                'data' => []
            ],
        ];

        foreach ($result as $row) {
            $time = $row->created_at->timestamp * 1000;
            $data['likes']['data'][] = [$time, $row->count];
        }

        return array_values($data);
    }
}
