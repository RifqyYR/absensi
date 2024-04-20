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
        // $schedule->call(function () {
        //     app()->make('App\Http\Controllers\AbsenceController')->createAbsenceToday();
        // })->dailyAt('05:00')->timezone('Asia/Singapore');
        $schedule->call(function () {
            app()->make('App\Http\Controllers\AbsenceController')->createAbsenceToday();
        })->everyTenSeconds();  
        $schedule->call(function () {
            app()->make('App\Http\Controllers\StudentController')->deleteByGeneration();
        })->yearlyOn(6, 1);
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
