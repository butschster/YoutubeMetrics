<?php

namespace App\Http\Controllers;

use App\Entities\Author;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return Author::live()->onlyBots()
            ->with('comments')
            ->has('comments', '>', 1)->get();
    }
}
