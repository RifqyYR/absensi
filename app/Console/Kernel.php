<?php

namespace App\Console;

use App\Http\Controllers\AbsenceController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->call(function () {
        //     app()->make('App\Http\Controllers\AbsenceController')->notAbsence();
        // })->dailyAt('08:31')->timezone('Asia/Singapore');
        $schedule->call(function () {
            app()->make('App\Http\Controllers\AbsenceController')->notAbsence();
        })->everyTenSeconds();
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
