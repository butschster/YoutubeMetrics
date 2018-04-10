<?php

namespace App\Http\Controllers\Video;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\ChartResource;
use Doctrine\Common\Cache\Cache;

class GetMetrics extends Controller
{
    /**
     * Получение данных для построения графика статистики для видео
     *
     * @param Video $video
     * @return ChartResource
     */
    public function __invoke(Video $video): ChartResource
    {
        $cacheKey = md5("video_stat".$video->id);

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($video) {
            return new ChartResource($video->statistics()->oldest()->get());
        });
    }
}