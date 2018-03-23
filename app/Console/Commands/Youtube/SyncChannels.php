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
    protected $processed = 0;

    /**
     * @var int
     */
    protected $chunkSize = 40;

    public function handle()
    {
        Channel::whereNull('name')->live()->select('id')
            ->chunk($this->chunkSize, function ($ids) {
                $ids = $ids->pluck('id')->all();

                dispatch(new UpdateChannelInformation($ids));

                $this->processed += $this->chunkSize;

                if ($this->processed > 5000) {
                    return false;
                }
            });
    }
}
