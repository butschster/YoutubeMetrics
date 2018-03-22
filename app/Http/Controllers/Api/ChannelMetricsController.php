<?php

namespace App\Http\Controllers\Api;

use App\Entities\Author;
use App\Entities\ChannelStat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelMetricsController extends Controller
{
    /**
     * @param Author $author
     * @return array
     */
    public function index(Author $author): array
    {
        $cacheKey = md5("channel_stat".$author->id);

        return Cache::remember($cacheKey, now()->addDay(), function () use ($author) {
            return $this->prepareData(
                ChannelStat::where('channel_id', $author->id)->oldest()->get()
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
                'name' => __('channel.stat.views'),
                'data' => []
            ],
            'subscribers' => [
                'name' => __('channel.stat.subscribers'),
                'data' => []
            ]
        ];

        foreach ($result as $row) {
            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['subscribers']['data'][] = [$time, $row->subscribers];
        }

        return array_values($data);
    }
}
