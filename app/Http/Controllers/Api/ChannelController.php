<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function check(Request $request)
    {
        $request->validate(['channel_id' => 'required']);

        $id = $request->channel_id;

        $author = Cache::remember('author:'.$id, now()->addHour(), function () use ($id) {
            return Author::live()->find($id);
        });

        return [
            'type' => !is_null($author)
                ? $author->type()
                : 'normal'
        ];
    }
}
