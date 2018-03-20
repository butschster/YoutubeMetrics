<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Author $author
     * @return array
     */
    public function markAsBot(Author $author)
    {
        $author->markAsBot();

        return ['status' => true];
    }

    /**
     * @param Author $author
     * @return array
     */
    public function markAsNormal(Author $author)
    {
        $author->reports = 0;
        $author->save();

        return ['status' => true];
    }
}
