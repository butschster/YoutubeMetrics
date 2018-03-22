<?php

namespace App\Http\Resources;

use App\Entities\Channel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChannelCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function(Channel $channel) {
            return [
                'id' => $channel->id,
                'name' => $channel->name,
                'link' => $channel->link,
                'thumb' => $channel->thumb,
                'reports' => $channel->reports,
                'views' => format_number($channel->views),
                'subscribers' => format_number($channel->subscribers),
                'bot_comments' => format_number($channel->bot_comments),
                'total_comments' => format_number($channel->total_comments),
            ];
        })->all();
    }
}
