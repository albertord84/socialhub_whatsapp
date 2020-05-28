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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:create_company_api_jobs')->cron('*/2 * * * *');
        $schedule->command('command:Create_company_bling_jobs')->cron('*/2 * * * *');
        $schedule->command('command:Create_company_tracking_jobs')->cron('*/5 * * * *');
        $schedule->command('command:Get_sales_bling')->cron('*/30 * * * *');
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
	    $schedule->command('log:copyedelete')->timezone('America/Sao_Paulo')->dailyAt('23:00');
	    $schedule->command('telescope:prune')->dailyAt('23:30');
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
