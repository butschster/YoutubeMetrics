<?php

namespace App\Console\Commands\Youtube;

use App\Entities\Video;
use App\Jobs\Youtube\SyncVideoComments;
use Illuminate\Console\Command;

class HourlyCommentsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:hourly-comments-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация комментариев (Период :hours часов)';

    /**
     * Период синхронизации комментариев
     *
     * @var int
     */
    protected $lifetime;

    public function __construct()
    {
        $this->lifetime = config('youtube.lifetime.comments');
        $this->description = strtr($this->description, [':hours' => $this->lifetime]);

        parent::__construct();
    }

    public function handle()
    {
        $videos = Video::where('created_at', '>', now()->subHours($this->lifetime))->get();

        foreach ($videos as $video) {
            dispatch(new SyncVideoComments($video->id));
        }
    }
}
