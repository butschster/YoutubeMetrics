<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Channel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:videos-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync youtube videos';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        /** @var Channel[] $channels */
        $channels = Channel::get();

        foreach ($channels as $channel) {
            try {
                $videos = $client->searchChannelVideos('', $channel->id, 3, 'date');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                continue;
            }


            foreach ($videos as $video) {
                $channel->videos()->firstOrCreate(['id' => $video->id->videoId], [
                    'id' => $video->id->videoId,
                    'title' => $video->snippet->title,
                    'description' => $video->snippet->description,
                    'created_at' => Carbon::parse($video->snippet->publishedAt)
                ]);
            }
        }
    }
}
