<?php

namespace App\Http\Resources;

use App\Entities\ChannelReport;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChannelReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function(ChannelReport $report) {
            return new ChannelReportResource($report);
        })->all();
    }
}