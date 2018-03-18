<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use Illuminate\Console\Command;

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

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        Channel::get()->each(function (Channel $channel) {
            dispatch(new UpdateChannelInformation($channel->id));
        });
    }
}
