<?php

namespace App\Http\Resources\Video;

use App\Entities\Video;
use App\Http\Resources\Channel\ShortInformationResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Video
 */
class VideoResource extends JsonResource
{
    /**
     * @param $request
     * @param string $field
     * @return bool
     */
    protected function wants($request, string $field): bool
    {
        $include = $request->get('include', []);

        if (!is_array($include)) {
            $include = [$include];
        }

        return in_array($field, $include);
    }

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
            'title' => $this->title,
            'description' => $this->description,
            'stat' => [
                'views' => format_number($this->views),
                'likes' => format_number($this->likes),
                'dislikes' => format_number($this->dislikes),
                'comments' => format_number($this->comments),
                'spam_comments' => $this->when(
                    $this->wants($request, 'spam_comments'), format_number($this->spam_comments)
                )
            ],
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at),
            'channel' => new ShortInformationResource($this->whenLoaded('channel')),
            'links' => [
                'self' => route('api.video.show', $this->id),
                'thumb' => $this->thumb,
                'youtube' => $this->youtube_link
            ]
        ];
    }
}
