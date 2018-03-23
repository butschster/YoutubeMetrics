<?php

namespace App\Console;

use App\Contracts\Services\Youtube\KeyManager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('kremlin-bots:sync')->hourly()->withoutOverlapping();
        $schedule->command('comments:mark-spam')->dailyAt('04:00')->withoutOverlapping();
        $schedule->command('channel:calculate-comments')->dailyAt('06:00')->withoutOverlapping();
        $schedule->command('channel:stat-bot-comments')->dailyAt('02:00')->withoutOverlapping();


        // YouTube tasks
        $this->runYoutubeTask(
            $schedule->command('kremlin-bots:check')->twiceDaily(),
            $schedule->command('youtube:channels-sync')->dailyAt('03:00'),
            $schedule->command('youtube:followed-channels-sync')->daily(),
            $schedule->command('youtube:videos-sync')->everyFiveMinutes(),
            $schedule->command('youtube:video-statistics-sync')->everyMinute(),
            $schedule->command('youtube:comments-sync')->everyThirtyMinutes()
        );
    }

    /**
     * @param \Illuminate\Console\Scheduling\Event[] ...$schedules
     */
    protected function runYoutubeTask(\Illuminate\Console\Scheduling\Event ...$schedules)
    {
        foreach ($schedules as $schedule) {
            $schedule->withoutOverlapping()->when(function (KeyManager $manager) {
                return $manager->hasKeys();
            });
        }
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
