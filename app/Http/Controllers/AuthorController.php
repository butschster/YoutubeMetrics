<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Author $author)
    {
        $videos = $author->videos()->latest()->paginate(3);

        return view('author.show', compact('author', 'videos'));
    }
}
