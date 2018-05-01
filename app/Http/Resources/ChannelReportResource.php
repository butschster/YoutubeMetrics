<?php

namespace App\Http\Resources;

use App\Entities\ChannelReport;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChannelReport
 */
class ChannelReportResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'channel_id' => $this->channel_id,
            'reporter_id'=> $this->user_id,
            'reporter' => new UserResource($this->whenLoaded('reporter')),
            'created_at' => format_date($this->created_at)
        ];
    }
}