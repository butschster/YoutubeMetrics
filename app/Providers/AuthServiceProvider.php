<?php

namespace App\Providers;

use App\Entities\{
    Channel, Video
};
use App\Policies\{
    ChannelPolicy, VideoPolicy
};
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Channel::class => ChannelPolicy::class,
        Video::class => VideoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('moderate', function (User $user) {
            return $user->moderator;
        });

        Gate::define('report', function (User $user) {
            return true;
        });
    }
}
