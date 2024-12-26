<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckSalesNotifications;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:recharge-expiry')->daily(); // Runs the check daily
                // Schedule the check-sales-notifications command to run daily
        $schedule->command('sales:check-notifications')->daily();

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
