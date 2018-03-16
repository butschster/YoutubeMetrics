<?php

namespace App\Http\Controllers;

use App\Entities\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function spamToday()
    {
        $comments = Comment::where('spam', true)->where('created_at', '>', now()->subDay())->latest()->paginate(100);
        
        return view('comments.index', compact('comments'));
    }
}
