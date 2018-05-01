<?php

namespace App\Http\Resources\Channel;

use App\Entities\Channel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Channel
 */
class ChannelResource extends ShortInformationResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge_recursive(parent::toArray($request), [
            'stat' => [
                'total_comments' => format_number($this->total_comments),
                'total_reports' => format_number($this->total_reports),
                'views' => format_number($this->views),
                'comments' => format_number($this->comments),
                'subscribers' => format_number($this->subscribers),
                'bot_comments' => format_number($this->bot_comments)
            ],
            'links' => [
                'youtube' => $this->youtube_link,
                't30' => $this->top_comments_link
            ],
            'verified' => $this->verified,
            'bot' => $this->bot,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at)
        ]);
    }
}
