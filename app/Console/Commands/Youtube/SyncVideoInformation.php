<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Video;
use App\Jobs\Youtube\UpdateVideoInformation;
use Illuminate\Console\Command;

class SyncVideoInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:video-statistics-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        /** @var Video[] $videos */
        $videos = Video::where('created_at', '>', now()->subDays(2))->get();

        foreach ($videos as $video) {
            dispatch(new UpdateVideoInformation($video->id));
        }
    }
}
