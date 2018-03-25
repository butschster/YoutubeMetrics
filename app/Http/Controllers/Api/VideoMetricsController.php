<?php

namespace App\Http\Controllers\Api;

use App\Entities\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\ChartResource;
use Illuminate\Support\Facades\Cache;

class VideoMetricsController extends Controller
{
    /**
     * Получение данных для построения графика статистики для видео
     *
     * @param Video $video
     * @return ChartResource
     */
    public function index(Video $video): ChartResource
    {
        $cacheKey = md5("video_stat".$video->id);

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($video) {
            return new ChartResource($video->statistics()->oldest()->get());
        });
    }
}
