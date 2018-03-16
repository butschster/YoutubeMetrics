<?php

namespace App\Http\Controllers\Api;

use App\Entities\VideoStat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VideoMetricsController extends Controller
{
    /**
     * @param string $videoId
     * @return mixed
     */
    public function index(string $videoId)
    {
        return Cache::remember("video_stat:".$videoId, now()->addMinutes(5), function () use ($videoId) {
            return $this->prepareData(
                VideoStat::where('video_id', $videoId)->oldest()->get()
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
