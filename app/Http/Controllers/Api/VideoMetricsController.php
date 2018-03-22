<?php

namespace App\Http\Controllers\Api;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VideoMetricsController extends Controller
{
    /**
     * @param Video $video
     * @return array
     */
    public function index(Video $video): array
    {
        $cacheKey = md5("video_stat".$video->id);

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($video) {
            return $this->prepareData(
                $video->statistics()->oldest()->get()
            );
        });
    }

    /**
     * @param $result
     * @return array
     */
    protected function prepareData($result): array
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

        foreach ($result as $row) {

            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['likes']['data'][] = [$time, $row->likes];
            $data['dislikes']['data'][] = [$time, $row->dislikes];
            $data['comments']['data'][] = [$time, $row->comments];
        }

        return array_values($data);
    }
}
