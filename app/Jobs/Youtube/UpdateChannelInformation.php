<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
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
        $this->channelId = $channelId;
    }

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $author = Author::find($this->channelId);
        $info = $client->getChannelById($this->channelId);

        if ($author && !$info) {
            $author->deleted = true;
            $author->save();
            return;
        } else if (!$author && !$info) {
            return;
        }

        Author::updateOrCreate(['id' => $info->id], [
            'name' => $info->snippet->title,
            'created_at' => Carbon::parse($info->snippet->publishedAt),
            'thumb' => $info->snippet->thumbnails->default->url,
            'country' => $info->snippet->country
        ]);
    }
}
