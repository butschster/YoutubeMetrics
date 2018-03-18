<?php

namespace App\Console\Commands;

use App\Entities\Channel;
use Illuminate\Console\Command;

class ChannelUnfollow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:unfollow {channel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Убрать канал из слежения';

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $channel = Channel::find($this->argument('channel'));

        if (!$channel) {
            $this->error('Канал не найден.');
            return;
        }

        $channel->delete();

        $this->info(sprintf('Слежение за каналом [%s] прекращено', $channel->title));
    }
}
