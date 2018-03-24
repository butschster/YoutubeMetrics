<?php

namespace App\Console\Commands\Youtube;

use App\Entities\Video;
use App\Jobs\Youtube\SyncVideoComments;
use Illuminate\Console\Command;

class DailyCommentsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:daily-comments-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Контрольная синхронизация комментариев, через день';

    public function handle()
    {
        $date = now()->subDay()->toDateString();
        $videos = Video::whereRaw("date(created_at) = '{$date}'")->get();

        foreach ($videos as $video) {
            dispatch(new SyncVideoComments($video->id));
        }
    }
}
