<?php

namespace App\Jobs\Youtube;

use App\Entities\Channel;
use App\Entities\Video;
use App\Services\Youtube\Resources\Comment;
use App\Services\Youtube\ResponseCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UpdateComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    public $videoId;

    /**
     * @var ResponseCollection
     */
    public $comments;

    /**
     * @param string $videoId
     * @param ResponseCollection|Comment[] $comments
     */
    public function __construct(string $videoId, ResponseCollection $comments)
    {
        $this->onQueue('comment');

        $this->videoId = $videoId;
        $this->comments = $comments;
    }

    public function handle()
    {
        $video = Video::find($this->videoId);

        if (!$video) {
            Log::debug("Video with id [{$this->videoId}] not found.");
            return;
        }

        foreach ($this->comments as $comment) {
            $channelId = $comment->getSnippet()->getAuthorChannelId();

            if (!Channel::where('id', $channelId)->exists()) {
                dispatch(new UpdateChannelInformation($channelId));
            }

            $video->comments()->updateOrCreate([
                'id' => $comment->id
            ], [
                'created_at' => $comment->getSnippet()->getPublishedAt(),
                'text' => $comment->getSnippet()->getTextOriginal(),
                'channel_id' => $channelId,
                'total_likes' => $comment->getSnippet()->getLikesCount(),
            ]);
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
