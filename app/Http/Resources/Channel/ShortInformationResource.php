<?php

namespace App\Http\Resources\Channel;

use App\Entities\Channel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

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
            'type' => $this->type,
            'links' => [
                'self' => route('api.channel.show', $this->id),
                'thumb' => $this->thumb,
            ],
            'policies' => [
                'report' => Gate::allows('report', $this->resource)
            ]
        ];
    }
}
