<?php

namespace App\Http\Controllers\Api;

use App\Entities\Video;
use App\Entities\VideoStat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VideoMetricsController extends Controller
{
    /**
     * @param Video $video
     * @return mixed
     */
    public function index(Video $video)
    {
        return Cache::remember("video_stat:".$video->id, now()->addMinutes(5), function () use ($video) {
            return $this->prepareData(
                VideoStat::where('video_id', $video->id)->oldest()->get()
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
                'name' => 'Просмотры',
                'data' => []
            ],
            'likes' => [
                'name' => 'Лайки',
                'data' => []
            ],
            'dislikes' => [
                'name' => 'Дизлайки',
                'data' => []
            ],
            'favorites' => [
                'name' => 'Избранное',
                'data' => []
            ],
            'comments' => [
                'name' => 'Комментарии',
                'data' => []
            ]
        ];

        foreach ($result as $row) {

            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['likes']['data'][] = [$time, $row->likes];
            $data['dislikes']['data'][] = [$time, $row->dislikes];
            $data['favorites']['data'][] = [$time, $row->favorites];
            $data['comments']['data'][] = [$time, $row->comments];
        }

        return array_values($data);
    }
}
