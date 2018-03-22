<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use App\Entities\Channel;
use App\Http\Resources\ChannelCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    /**
     * @return ChannelCollection
     */
    public function followed(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember('following-channels', now()->addHour(), function () {
                return Channel::with('author')->whereHas('author')->get()
                    ->map(function (Channel $channel) {
                        return $channel->author;
                    })
                    ->sortByDesc('subscribers');
            })
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function check(Request $request): array
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

    /**
     * @return ChannelCollection
     */
    public function reported(): ChannelCollection
    {
        return new ChannelCollection(
            Author::onlyReported()->live()->get()
        );
    }

    /**
     * @return ChannelCollection
     */
    public function bots(): ChannelCollection
    {
        return new ChannelCollection(
            Cache::remember('bots', now()->addHour(), function () {
                return Author::onlyBots()->live()->orderBy('total_comments')->get();
            })
        );
    }
}
