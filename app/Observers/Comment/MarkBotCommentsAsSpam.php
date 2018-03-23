<?php

namespace App\Observers\Comment;

use App\Entities\Comment;

class MarkBotCommentsAsSpam
{
    /**
     * При добавлении комментария пометка как спам, если автор бот
     *
     * @param Comment $comment
     */
    public function creating(Comment $comment)
    {
        $comment->is_spam = $comment->channel()->onlyBots()->exists();
    }
}