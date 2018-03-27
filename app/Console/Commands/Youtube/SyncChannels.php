<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Entities\Channel;
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
    protected $description = 'Синхронизация каналов без профилей';

    /**
     * @var int
     */
    protected $chunkSize = 40;

    /**
     * @var int
     */
    protected $channelsLinit = 10000;

    public function handle()
    {
        $total = $this->channelsLinit;
        $chunk = 500;
        $page = 1;

        while ($total > 0) {
            Channel::whereNull('name')->live()->forPage($page, $chunk)->get(['id'])
                ->chunk($this->chunkSize)
                ->each(function ($ids) {
                    $ids = $ids->pluck('id')->all();

                    dispatch(new UpdateChannelInformation($ids));
                });

            $page++;
            $total -= $chunk;
        }
    }
}
