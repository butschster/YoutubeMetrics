<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Channel;
use App\Services\Youtube\NotFoundException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateChannelInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $channelId;

    /**
     * Create a new job instance.
     *
     * @param string $channelId
     */
    public function __construct(string $channelId)
    {
        $this->onQueue('common');

        $this->channelId = $channelId;
    }

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $channel = Channel::find($this->channelId);

        try {
            $info = $client->getChannelById($this->channelId);
        } catch (NotFoundException $exception) {
            if ($channel) {
                $channel->deleted = true;
                $channel->save();
                return;
            }

            return;
        }

        $channel = Channel::updateOrCreate(
            ['id' => $info->getId()],
            array_merge([
                'name' => $info->getSnippet()->getTitle(),
                'created_at' => $info->getSnippet()->getPublishedAt(),
                'thumb' => $info->getSnippet()->getThumb(),
                'country' => $info->getSnippet()->getCountry()
            ], $info->getStatistics()->toArray()));

        $channel->statistics()->create(
            array_merge(
                $info->getStatistics()->toArray(),
                ['bot_comments' => $channel->bot_comments]
            )
        );
    }
}
