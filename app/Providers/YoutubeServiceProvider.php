<?php

namespace App\Providers;

use App\Contracts\Services\Youtube\{
    Client as CleintContract,
    KeyManager as KeyManagerContract
};
use App\Entities\YoutubeKey;
use App\Services\Youtube\{
    Client, KeyManager
};
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
        $this->app->singleton(KeyManagerContract::class, function ($app) {
            $manager = new KeyManager($this->app);

            $manager->setKeys(
                YoutubeKey::getKeys()
            );

            return $manager;
        });

        $this->app->singleton(CleintContract::class, function ($app) {
            $keyManager = $app->make(KeyManagerContract::class);

            $client = new Client($keyManager);
            $client->setHttpClient(new \GuzzleHttp\Client());

            return $client;
        });
    }
}
