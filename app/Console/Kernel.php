<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AutoAbsentCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('auto:absent')
            ->dailyAt('22:14')
            ->days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY, Schedule::SATURDAY]);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
