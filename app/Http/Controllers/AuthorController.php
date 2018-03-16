<?php

namespace App\Http\Controllers;

use App\Entities\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Author $author)
    {
        return view('author.show', compact('author'));
    }
}
