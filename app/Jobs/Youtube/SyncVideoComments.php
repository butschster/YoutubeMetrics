<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Video;
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
    public $video;

    /**
     * Create a new job instance.
     *
     * @param Video|string $video
     */
    public function __construct($video)
    {
        $this->onQueue('comment');

        if ($video instanceof Video) {
            $video = $video->getKey();
        }

        $this->video = $video;
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
        $comments = $client->getCommentThreads($this->video, 100, $pageToken);
        dispatch(new UpdateComments($this->video, $comments));

        if ($comments->hasNextPage()) {
            $this->syncComments($client, $comments->getNextPageToken());
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['youtube', 'comment'];
    }

}
