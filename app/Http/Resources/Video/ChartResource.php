<?php

namespace App\Http\Resources\Video;

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
                'name' => __('video.stat.views'),
                'data' => []
            ],
            'likes' => [
                'name' => __('video.stat.likes'),
                'data' => []
            ],
            'dislikes' => [
                'name' => __('video.stat.dislikes'),
                'data' => []
            ],
            'comments' => [
                'name' => __('video.stat.comments'),
                'data' => []
            ]
        ];

        foreach ($this->resource as $row) {
            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['likes']['data'][] = [$time, $row->likes];
            $data['dislikes']['data'][] = [$time, $row->dislikes];
            $data['comments']['data'][] = [$time, $row->comments];
        }

        return array_values($data);
    }
}
