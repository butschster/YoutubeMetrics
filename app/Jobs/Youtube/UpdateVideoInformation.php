<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Video;
use App\Services\Youtube\NotFoundException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateVideoInformation implements ShouldQueue
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
        $this->onQueue('video');
        $this->videoId = $videoId;
    }

    /**
     * @param Client $client
     * @throws \App\Services\Youtube\ResponseException
     */
    public function handle(Client $client)
    {
        $video = Video::find($this->videoId);

        if (!$video) {
            return;
        }

        try {
            $info = $client->getVideoInfo($video->id);
        } catch (NotFoundException $exception) {
            return;
        }

        foreach ($info->getSnippet()->getTags() as $tag) {
            $video->tags()->firstOrCreate(['name' => $tag]);
        }

        $video->update(
            array_merge($info->getStatistics()->toArray(), [
                'title' => $info->getSnippet()->getTitle(),
                'thumb' => $info->getSnippet()->getThumb(),
                'description' => $info->getSnippet()->getDescription()
            ])
        );

        $video->statistics()->create(
            $info->getStatistics()->toArray()
        );
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['youtube', 'video'];
    }
}
