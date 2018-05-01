<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\CommentRepository;
use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentsCollection;

class GetSpamComments extends Controller
{

    /**
     * Получение списка всех комментариев канала, написанных ботами
     *
     * @param CommentRepository $repository
     * @param Channel $channel
     * @return CommentsCollection
     */
    public function __invoke(CommentRepository $repository, Channel $channel): CommentsCollection
    {
        return new CommentsCollection(
            $repository->getChannelSpamComments($channel->id)
        );
    }
}