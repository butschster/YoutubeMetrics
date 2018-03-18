<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
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
        Author::whereNull('name')->chunk(50, function (Collection $authors) use($client) {

            $authors = $authors->keyBy('id');
            $result = $client->getChannelsByIds($authors->pluck('id')->all());

            foreach ($result as $channel) {

                $author = $authors->pull($channel->id);

                $author->update([
                    'id' => $channel->id,
                    'name' => $channel->snippet->title,
                    'created_at' => Carbon::parse($channel->snippet->publishedAt),
                    'thumb' => $channel->snippet->thumbnails->default->url,
                    'country' => $channel->snippet->country ?? 'RU'
                ]);
            }

        });
    }
}
