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
          // Resetar o lucro no início de cada mês
    $schedule->call(function () {
        \App\Models\MonthlyEarnings::query()->update(['total_lucro' => 0]);
    })->monthlyOn(1, '00:00'); // Executa no dia 1 de cada mês à meia-noite
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
