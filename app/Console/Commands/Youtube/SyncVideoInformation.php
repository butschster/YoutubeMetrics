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
    protected $signature = 'youtube:video-information-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сбор информации о видео';

    public function handle()
    {
        $lifetime = config('youtube.lifetime.videos');

        Video::where('created_at', '>', now()->subHours($lifetime))->chunk(50, function ($videos) {

            foreach ($videos as $video) {
                dispatch(
                    new UpdateVideoInformation($video)
                );
            }

        });
    }
}
