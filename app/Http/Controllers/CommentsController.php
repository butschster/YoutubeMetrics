<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use App\Services\TextToImage\Font;
use App\Services\TextToImage\Text;
use App\Services\TextToImage\TextToImage;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function spamToday()
    {
        $comments = Comment::onlySpam()
            ->with('channel')->where('created_at', '>', now()->subDay())->latest()->paginate(100);

        return view('comment.index', compact('comments'));
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Comment $comment)
    {
        $channel = $comment->channel;

        $this->meta->setTitle(
            sprintf('Комментарий - %s от %s', $comment->id, $channel->name ?? $comment->channel_id)
        );

        return view('comment.show', compact('comment', 'channel'));
    }

//    public function image(Comment $comment)
//    {
//        $channel = $comment->channel;
//        $test = new TextToImage(600, 50);
//
//        $test->append(new Text($comment->text, new Font(20, resource_path('assets/fonts/RobotoCondensed-Regular.ttf'))));
//        $test->append(new Text(' - '.$channel->name, new Font(12, resource_path('assets/fonts/RobotoCondensed-Regular.ttf'))));
//
//        $test->render();
//    }
}
