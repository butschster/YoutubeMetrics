<?php

namespace App\Console\Commands;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use Illuminate\Console\Command;

class ChannelFollow extends Command
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
            $this->error('Вы уже следите за этим каналом.');
            return;
        }

        $info = $client->getChannelById($this->argument('channel'));

        if (!$info) {
            $this->error('Канал с таким ID не существует.');
            return;
        }

        $channel = Channel::create([
            'id' => $info->id,
            'title' => $info->snippet->title
        ]);

        dispatch(new UpdateChannelInformation($info->id));

        $this->info(sprintf('Добавлено слежение за каналом [%s]', $channel->title));
    }
}
