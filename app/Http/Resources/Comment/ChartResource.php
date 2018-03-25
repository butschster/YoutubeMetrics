<?php

namespace App\Http\Resources\Comment;

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
            'likes' => [
                'name' => 'Лайки',
                'data' => []
            ],
        ];

        foreach ($result as $row) {
            $time = $row->created_at->timestamp * 1000;
            $data['likes']['data'][] = [$time, $row->count];
        }

        return array_values($data);
    }
}
