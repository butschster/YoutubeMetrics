<?php

namespace App\Http\Resources\Channel;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'views' => [
                'name' => __('channel.stat.views'),
                'data' => []
            ],
            'subscribers' => [
                'name' => __('channel.stat.subscribers'),
                'data' => []
            ],
            'bot_comments' => [
                'name' => __('channel.stat.bot_comments'),
                'data' => []
            ]
        ];

        foreach ($this->resource as $row) {
            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['subscribers']['data'][] = [$time, $row->subscribers];
            $data['bot_comments']['data'][] = [$time, $row->bot_comments ?? 0];
        }

        return array_values($data);
    }
}
