<?php

namespace App\Providers;

use App\Entities\Comment;
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
        $this->addCommentBinding();

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

    protected function addVideoBinding(): void
    {
        Route::bind('video', function ($id) {
            $cacheKey = md5('video'.$id);

            $video = Cache::remember($cacheKey, now()->addHour(), function () use ($id) {
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
}
