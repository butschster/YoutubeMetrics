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
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id)
    {
        $author = Author::find($id);

        if (!$author && $authorData = $this->client->getChannelById($id)) {
            $author = Author::create([
                'id' => $authorData->id,
                'name' => $authorData->snippet->title,
                'created_at' => Carbon::parse($authorData->snippet->publishedAt),
                'thumb' => $authorData->snippet->thumbnails->default->url,
                'country' => $authorData->snippet->country
            ]);
        }

        if (!$author) {
            abort(404);
        }

        $videos = $author->videos()->latest()->paginate(3);

        return view('author.show', compact('author', 'videos'));
    }
}
