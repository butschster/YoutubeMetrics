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
            $keys = $app['config']->get('services.youtube.keys', []);

            return new Client([
                'key' => $keys[array_rand($keys)]
            ]);
        });
    }
}
