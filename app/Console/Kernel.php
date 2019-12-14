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
        Commands\ChangeMembership::class,
        Commands\ChangeRoomRate::class,
        Commands\ChangeRoomStatus::class,
        Commands\NightAudit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command(Commands\ChangeMembership::class)->dailyAt('23:00')->when(function () {
            return \Carbon\Carbon::now()->endofYear()->isToday();
        });

        $schedule->command(Commands\ChangeRoomStatus::class)->dailyAt('23:59');
        $schedule->command(Commands\NightAudit::class)->dailyAt('01:59');
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
