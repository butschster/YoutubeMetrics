<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Entities\Comment;
use App\Jobs\Youtube\UpdateChannelInformation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class SyncChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:channels-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация профилей каналов';

    public function handle()
    {
        $channels = Comment::select('channel_id')
            ->whereDoesntHave('channel')
            ->groupBy('channel_id')
            ->pluck('channel_id');

        $this->info("Found channels [".$channels->count()."]");
        foreach ($channels as $id) {
            dispatch(new UpdateChannelInformation($id));
        }
    }
}
