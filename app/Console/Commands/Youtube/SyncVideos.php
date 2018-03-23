<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\FollowedChannel;
use Illuminate\Console\Command;

class SyncVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:channels-follow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Слежение за новыми видео на каналах';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        /** @var FollowedChannel[] $channels */
        $channels = FollowedChannel::get();

        foreach ($channels as $channel) {
            try {
                $videos = $client->searchChannelVideos('', $channel->id, 3, 'date');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                continue;
            }

            foreach ($videos as $video) {

                // Если видео в статусе запланировано, то пропускаем его
                if ($video->getSnippet()->isUpcoming()) {
                    continue;
                }

                $channel->videos()->updateOrCreate(['id' => $video->id->videoId], [
                    'id' => $video->id->videoId,
                    'title' => $video->getSnippet()->getTitle(),
                    'thumb' => $video->getSnippet()->getThumb(),
                    'description' => $video->getSnippet()->getDescription(),
                    'created_at' => $video->getSnippet()->getPublishedAt()
                ]);
            }
        }
    }
}
