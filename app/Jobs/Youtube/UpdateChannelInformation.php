<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Exceptions\Youtube\NotFoundException;
use Carbon\Carbon;
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
        $author = Author::find($this->channelId);

        try {
            $info = $client->getChannelById($this->channelId);
        } catch (NotFoundException $exception) {

            if ($author) {
                $author->deleted = true;
                $author->save();
                return;
            }

            return;
        }

        $author = Author::updateOrCreate(['id' => $info->getId()], array_merge([
            'name' => $info->getSnippet()->getTitle(),
            'created_at' => $info->getSnippet()->getPublishedAt(),
            'thumb' => $info->getSnippet()->getThumb(),
            'country' => $info->getSnippet()->getCountry()
        ], $info->getStatistics()->toArray()));

        $author->statistics()->create(
            $info->getStatistics()->toArray()
        );
    }
}
