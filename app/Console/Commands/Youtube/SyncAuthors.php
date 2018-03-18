<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Entities\Comment;
use App\Jobs\Youtube\UpdateChannelInformation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SyncAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:authors-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация профилей каналов';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $authors = Comment::select('author_id')->whereDoesntHave('author')->groupBy('author_id')->pluck('author_id');

        foreach ($authors as $id) {
            dispatch(new UpdateChannelInformation($id));
        }

//        Author::whereNull('name')->chunk(20, function (Collection $authors) use($client) {
//            $authors = $authors->keyBy('id');
//
//            try {
//                $result = $client->getChannelsByIds($authors->pluck('id')->all());
//
//                foreach ($result as $channel) {
//                    $author = $authors->pull($channel->id);
//
//                    $author->update([
//                        'id' => $channel->id,
//                        'name' => $channel->snippet->title,
//                        'created_at' => Carbon::parse($channel->snippet->publishedAt),
//                        'thumb' => $channel->snippet->thumbnails->default->url,
//                        'country' => $channel->snippet->country ?? 'RU'
//                    ]);
//                }
//
//                foreach ($authors as $author) {
//                    $author->update([
//                        'deleted' => true
//                    ]);
//                }
//            } catch (\Exception $e) {
//                $this->error($e->getMessage());
//            }
//        });
    }
}
