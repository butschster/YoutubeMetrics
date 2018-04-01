<?php

namespace App\Http\Resources\Channel;

use App\Entities\Channel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Channel
 */
class ShortInformationResource extends JsonResource
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
            'name' => $this->name,
            'links' => [
                'self' => route('api.channel.show', $this->id),
                'thumb' => $this->thumb,
            ]
        ];
    }
}
