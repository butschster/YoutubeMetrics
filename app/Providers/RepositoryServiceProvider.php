<?php

namespace App\Providers;

use App\Contracts\Repositories\{
    ChannelRepository as ChannelRepositoryContract,
    CommentRepository as CommentRepositoryContract
};
use App\Repositories\{
    ChannelRepository, CommentRepository
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(ChannelRepositoryContract::class, ChannelRepository::class);
        $this->app->bind(CommentRepositoryContract::class, CommentRepository::class);
    }
}
