<?php

namespace App\Providers;

use App\Contracts\Services\Youtube\Client as CleintContract;
use App\Services\Youtube\Client;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CleintContract::class, function ($app) {
            return new Client($app['config']->get('services.youtube'));
        });
    }
}
