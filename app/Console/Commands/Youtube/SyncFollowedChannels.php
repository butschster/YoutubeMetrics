<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\FollowedChannel;
use App\Jobs\Youtube\UpdateChannelInformation;
use Illuminate\Console\Command;

class SyncFollowedChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:followed-channels-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация профилей каналов';

    public function handle()
    {
        FollowedChannel::onlyFollow()->get()->each(function (FollowedChannel $channel) {
            dispatch(new UpdateChannelInformation($channel->id));
        });
    }
}
