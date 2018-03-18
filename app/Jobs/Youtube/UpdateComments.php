<?php

namespace App\Jobs\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Author;
use App\Entities\Video;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    public $videoId;

    /**
     * @var \stdClass
     */
    public $comments;

    /**
     * @param string $videoId
     * @param $comments
     */
    public function __construct(string $videoId, $comments)
    {
        $this->onQueue('comment');

        $this->videoId = $videoId;
        $this->comments = $comments;
    }

    public function handle()
    {
        $video = Video::find($this->videoId);

        if (!$video) {
            return;
        }

        foreach ($this->comments as $comment) {
            $channelId = $comment->snippet->topLevelComment->snippet->authorChannelId->value;

            if (!Author::where('id', $channelId)->exists()) {
                dispatch(new UpdateChannelInformation($channelId));
            }

            $video->comments()->updateOrCreate([
                'id' => $comment->id
            ], [
                'created_at' => Carbon::parse($comment->snippet->topLevelComment->snippet->publishedAt),
                'text' => $comment->snippet->topLevelComment->snippet->textOriginal,
                'channel_id' => $channelId,
                'total_likes' => $comment->snippet->topLevelComment->snippet->likeCount,
            ]);
        }
    }
}
