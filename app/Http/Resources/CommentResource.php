<?php

namespace App\Http\Resources;

use App\Entities\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'total_likes' => $this->total_likes,
            'video_id' => $this->video_id,
            'channel_id' => $this->channel_id,
            'channel_type' => $this->channel->type,
            'channel_name' => $this->channel->id ?? $this->channel_id,
            'created_at' => $this->formatted_date,
        ];
    }
}
