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
     * @var array
     */
    public $channelIds;

    /**
     * Create a new job instance.
     *
     * @param string|array $channelIds
     */
    public function __construct($channelIds)
    {
        $this->onQueue('common');

        $this->channelIds = !is_array($channelIds) ? [$channelIds] : $channelIds;
    }

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $result = $client->getChannelsById($this->channelIds)
            ->keyBy(function ($channel) {
                return $channel->getId();
            });

        foreach ($this->channelIds as $id) {
            $info = $result->get($id);
            if ($info) {
                $this->updateChannel($info);
                continue;
            }

            $this->deleteChannel($id);
        }
    }

    /**
     * @param \App\Services\Youtube\Resources\Channel $info
     */
    protected function updateChannel(\App\Services\Youtube\Resources\Channel $info)
    {
        $channel = Channel::updateOrCreate(
            ['id' => $info->getId()],
            array_merge([
                'name' => $info->getSnippet()->getTitle(),
                'created_at' => $info->getSnippet()->getPublishedAt(),
                'thumb' => $info->getSnippet()->getThumb(),
                'country' => $info->getSnippet()->getCountry()
            ], $info->getStatistics()->toArray()
            )
        );

        $channel->statistics()->create(
            array_merge(
                $info->getStatistics()->toArray(),
                ['bot_comments' => $channel->bot_comments]
            )
        );
    }

    /**
     * @param string $id
     */
    protected function deleteChannel(string $id)
    {
        if ($channel = Channel::find($id)) {
            $channel->deleted = true;
            $channel->save();
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['youtube', 'channel'];
    }
}
