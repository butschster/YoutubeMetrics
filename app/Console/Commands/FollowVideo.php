<?php

namespace App\Console\Commands;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Video;
use App\Exceptions\Youtube\NotFoundException;
use Illuminate\Console\Command;

class FollowVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:follow {video}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Слежение за видео';

    /**
     * @param Client $client
     * @throws \App\Services\Youtube\ResponseException
     */
    public function handle(Client $client)
    {
        $video = Video::find($this->argument('video'));

        if ($video) {
            $this->error('вы уже следите за этим видео.');
            return;
        }

        try {
            $info = $client->getVideoInfo($this->argument('video'));
        } catch (NotFoundException $exception) {
            $this->error('Канал с таким ID не существует.');
            return;
        }

        if (!$info) {
            $this->error('Видео с таким ID не существует.');
            return;
        }

        Video::create([
            'id' => $info->getId(),
            'channel_id' => $info->getSnippet()->getChannelId(),
            'title' => $info->getSnippet()->getTitle(),
            'thumb' => $info->getSnippet()->getThumb(),
            'description' => $info->getSnippet()->getDescription(),
            'created_at' => $info->getSnippet()->getPublishedAt()
        ]);
    }
}
