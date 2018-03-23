<?php

namespace App\Observers\Comment;

use App\Entities\Comment;

class UpdateStatistics
{
    /**
     * Если кол-во лайков изменилось, то добавляем значение в статистику
     *
     * @param Comment $comment
     */
    public function updated(Comment $comment)
    {
        if ($comment->isDirty(['total_likes'])) {
            $comment->likes()->create(['count' => $comment->total_likes]);
        }
    }
}