<?php

namespace App\Console\Commands;

use App\Contracts\Services\Youtube\Client;
use App\Entities\FollowedChannel;
use App\Services\Youtube\NotFoundException;
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
        $channel = FollowedChannel::find($this->argument('channel'));

        if ($channel) {
            $this->error('Вы уже следите за этим каналом.');
            return;
        }

        try {
            $info = $client->getChannelById($this->argument('channel'));
        } catch (NotFoundException $exception) {
            $this->error('Канал с таким ID не существует.');
            return;
        }

        $channel = FollowedChannel::create([
            'id' => $info->getId(),
            'title' => $info->getSnippet()->getTitle()
        ]);

        dispatch(new UpdateChannelInformation($channel->id));

        $this->info(sprintf('Добавлено слежение за каналом [%s]', $channel->title));
    }
}
