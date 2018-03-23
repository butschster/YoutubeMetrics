<?php

namespace App\Providers;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Tag;
use App\Entities\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->addVideoBinding();
        $this->addChannelBinding();
        $this->addCommentBinding();
        $this->addTagBinding();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function addChannelBinding(): void
    {
        Route::bind('channel', function ($id) {
            $cacheKey = md5('channel'.$id);

            $channel = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($id) {
                return Channel::find($id);
            });

            if (!$channel) {
                abort(404, 'Канал не найден');
            }

            return $channel;
        });
    }

    protected function addVideoBinding(): void
    {
        Route::bind('video', function ($id) {
            $cacheKey = md5('video'.$id);

            $video = Cache::remember($cacheKey, now()->addMinutes(20), function () use ($id) {
                return Video::find($id);
            });

            if (!$video) {
                abort(404, 'Видео не найдено');
            }

            return $video;
        });
    }

    protected function addCommentBinding(): void
    {
        Route::bind('comment', function ($id) {
            $cacheKey = md5('comment'.$id);

            $comment = Cache::remember($cacheKey, now()->addHour(), function () use ($id) {
                return Comment::find($id);
            });

            if (!$comment) {
                abort(404, 'Комментарий не найден');
            }

            return $comment;
        });
    }

    protected function addTagBinding(): void
    {
        Route::bind('tag', function ($name) {
            $cacheKey = md5('tag'.$name);

            $tag = Cache::remember($cacheKey, now()->addHour(), function () use ($name) {
                return Tag::where('name', $name)->first();
            });

            if (!$tag) {
                abort(404, 'Тег не найден');
            }

            return $tag;
        });
    }
}
