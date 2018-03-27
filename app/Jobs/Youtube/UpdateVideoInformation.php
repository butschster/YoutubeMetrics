<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\{
    Tag, Video
};
use App\Services\Youtube\NotFoundException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UpdateVideoInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $video;

    /**
     * @param Video|string $video
     */
    public function __construct($video)
    {
        $this->onQueue('video');

        if ($video instanceof Video) {
            $video = $video->getKey();
        }

        $this->video = $video;
    }

    /**
     * @param Client $client
     * @throws \App\Services\Youtube\ResponseException
     */
    public function handle(Client $client)
    {
        $video = Video::find($this->video);

        if (!$video) {
            Log::debug("Video with id [{$this->video}] not found.");
            return;
        }

        try {
            $info = $client->getVideoInfo($video->id);
        } catch (NotFoundException $exception) {
            Log::debug("Youtube: video with id [{$this->video}] not found.");
            return;
        }

        $tags = [];
        foreach ($info->getSnippet()->getTags() as $tag) {
            $tag = Tag::firstOrCreate(['name' => trim($tag)]);
            $tags[] = $tag->getKey();
        }
        $video->tags()->sync($tags);

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
