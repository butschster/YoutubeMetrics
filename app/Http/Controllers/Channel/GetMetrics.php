<?php

namespace App\Http\Controllers\Channel;

use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Channel\ChartResource;
use Illuminate\Support\Facades\Cache;

class GetMetrics extends Controller
{
    /**
     * Получение данных для построения графика
     *
     * @param Channel $channel
     * @return ChartResource
     */
    public function __invoke(Channel $channel): ChartResource
    {
        $cacheKey = md5("channel_stat".$channel->id);

        return Cache::remember($cacheKey, now()->addDay(), function () use ($channel) {
            return new ChartResource($channel->statistics()->oldest()->get());
        });
    }
}
