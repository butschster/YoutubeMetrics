<?php

namespace App\Http\Resources\Channel;

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
            return new ShortInformationResource($channel);
        })->all();
    }
}
