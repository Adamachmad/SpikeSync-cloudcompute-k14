<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Fetch workout data setiap hari pukul 2 pagi
        $schedule->command('volley:fetch-workout')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->onSuccess(function() {
                \Log::info('volley:fetch-workout command executed successfully');
            })
            ->onFailure(function() {
                \Log::error('volley:fetch-workout command failed');
            });

        // Generate leaderboard setiap jam
        $schedule->command('volley:generate-leaderboard')
            ->hourly()
            ->withoutOverlapping()
            ->onSuccess(function() {
                \Log::info('volley:generate-leaderboard command executed successfully');
            })
            ->onFailure(function() {
                \Log::error('volley:generate-leaderboard command failed');
            });

        // Cleanup old logs setiap minggu
        $schedule->command('cache:prune-stale-tags')
            ->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
