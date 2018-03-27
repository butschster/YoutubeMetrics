<?php

namespace App\Providers;

use App\Contracts\Services\MetaBot\Client as ClientContract;
use App\Services\MetaBot\Client;
use Illuminate\Support\ServiceProvider;

class MetaBotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ClientContract::class, function ($app) {
            return new Client(new \GuzzleHttp\Client);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
