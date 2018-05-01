<?php

namespace App\Http\Resources\Comment;

use App\Entities\Comment;
use App\Http\Resources\Channel\ShortInformationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'stat' => [
                'likes' => $this->total_likes
            ],
            'video' => [
                'id' => $this->video_id
            ],
            'channel' => new ShortInformationResource($this->channel),
            'created_at' => format_date($this->created_at),
            'links' => [
                'youtube' => $this->youtube_link
            ]
        ];
    }
}
