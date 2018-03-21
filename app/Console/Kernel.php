<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('kremlin-bots:sync')->hourly()->withoutOverlapping();
        $schedule->command('kremlin-bots:check')->twiceDaily()->withoutOverlapping();

        $schedule->command('youtube:videos-sync')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('youtube:video-statistics-sync')->everyMinute()->withoutOverlapping();

        $schedule->command('youtube:comments-sync')->everyThirtyMinutes()->withoutOverlapping();

        $schedule->command('authors:calculate-comments')->dailyAt('06:00')->withoutOverlapping();

        $schedule->command('comments:mark-spam')->dailyAt('04:00')->withoutOverlapping();
        $schedule->command('youtube:authors-sync')->dailyAt('03:00')->withoutOverlapping();
        $schedule->command('youtube:channels-sync')->daily()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
