<?php

namespace App\Console\Commands\Youtube;

use App\Entities\Video;
use App\Jobs\Youtube\SyncVideoComments;
use Illuminate\Console\Command;

class SyncComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:comments-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle()
    {
        $lifetime = config('youtube.lifetime.comments');

        $videos = Video::where('created_at', '>', now()->subHours($lifetime))->get();

        foreach ($videos as $video) {
            dispatch(new SyncVideoComments($video->id));
        }
    }
}
