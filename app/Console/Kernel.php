<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\CalculateAnalytics::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('analytics:calculate')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->commands = [
            \App\Console\Commands\CalculateAnalytics::class,
        ];

        require base_path('routes/console.php');
    }
}