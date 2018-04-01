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
                'total_comments' => $this->total_comments,
                'total_reports' => $this->total_reports,
                'views' => $this->views,
                'comments' => $this->comments,
                'subscribers' => $this->subscribers,
                'bot_comments' => $this->bot_comments
            ],
            'links' => [
                'youtube' => $this->youtube_link,
                't30' => $this->top_comments_link
            ],
            'type' => $this->type,
            'verified' => $this->verified,
            'bot' => $this->bot,
            'created_at' => format_date($this->created_at),
            'updated_at' => format_date($this->updated_at)
        ]);
    }
}
