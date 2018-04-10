<?php

namespace App\Http\Controllers\Comment;

use App\Entities\Comment;
use App\Entities\CommentLike;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\ChartResource;
use Illuminate\Support\Facades\Cache;

class GetMetrics extends Controller
{
    /**
     * Получение данных по лайкам комментариев для построения графика
     *
     * @param Comment $comment
     * @return ChartResource
     */
    public function __invoke(Comment $comment): ChartResource
    {
        return Cache::remember("comment_stat:".$comment->id, now()->addMinutes(5), function () use ($comment) {
            return new ChartResource(
                CommentLike::where('comment_id', $comment->id)->oldest()->get()
            );
        });
    }
}