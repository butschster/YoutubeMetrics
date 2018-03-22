<?php

namespace App\Http\Controllers\Api;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelMetricsController extends Controller
{
    /**
     * @param Channel $channel
     * @return array
     */
    public function index(Channel $channel): array
    {
        $cacheKey = md5("channel_stat".$channel->id);

        return Cache::remember($cacheKey, now()->addDay(), function () use ($channel) {
            return $this->prepareData(
                $channel->statistics()->oldest()->get()
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
            ],
            'bot_comments' => [
                'name' => __('channel.stat.bot_comments'),
                'data' => []
            ]
        ];

        foreach ($result as $row) {
            $time = $row->created_at->timestamp * 1000;

            $data['views']['data'][] = [$time, $row->views];
            $data['subscribers']['data'][] = [$time, $row->subscribers];
            $data['bot_comments']['data'][] = [$time, $row->bot_comments ?? 0];
        }

        return array_values($data);
    }
}
