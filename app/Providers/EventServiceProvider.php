<?php

namespace App\Providers;

use App\Entities\{
    Channel, Comment
};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\Youtube\DailyLimitExceeded::class => [
            \App\Listeners\Youtube\BanLimitedKey::class
        ],
        \App\Events\Channel\Reported::class => [

        ],
        \App\Events\Channel\Moderated::class => [

        ],
    ];

    protected $observers = [
        Channel::class => [
            \App\Observers\Channel\ClearCacheObserver::class
        ],
        Comment::class => [
            \App\Observers\Comment\UpdateStatistics::class,
            \App\Observers\Comment\MarkBotCommentsAsSpam::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        foreach ($this->observers as $model => $observers) {

            foreach ($observers as $observer) {
                $model::observe($observer);
            }
        }
    }
}
