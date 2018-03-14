<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Services\Youtube\Resources\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncVideoComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $videoId;

    /**
     * Create a new job instance.
     *
     * @param string $videoId
     */
    public function __construct(string $videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $this->syncComments($client);
    }

    /**
     * @param Client $client
     * @param string|null $pageToken
     */
    protected function syncComments(Client $client, string $pageToken = null): void
    {
        try {
            $comments = $client->getCommentThreads($this->videoId, 100, $pageToken);
            dispatch(new UpdateComments($this->videoId, $comments));

            if ($comments->hasNextPage()) {
                $this->syncComments($client, $comments->getNextPageToken());
            }
        } catch (\Exception $e) {

        }
    }
}
