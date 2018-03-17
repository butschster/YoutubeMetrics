<?php

namespace App\Console\Commands;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Channel;
use Illuminate\Console\Command;

class FollowChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:follow {channel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Слежение за видео канала.';


    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $channel = Channel::find($this->argument('channel'));

        if ($channel) {
            $this->error('вы уже следите за этим каналом.');
            return;
        }

        $info = $client->getChannelById($this->argument('channel'));

        if (!$info) {
            $this->error('Канал с таким ID не существует.');
            return;
        }

        Channel::create([
            'id' => $info->id,
            'title' => $info->snippet->title
        ]);
    }
}
