<?php

namespace App\Console;

use App\Console\Commands\AddDayOffMonth;
use App\Console\Commands\MoveDayOffEndYear;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SentMailEvent;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = array(
        SentMailEvent::class,
        AddDayOffMonth::class,
        MoveDayOffEndYear::class
    );

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Hện thống sẽ tự động check DB và gửi mail lúc 8h sáng
        $schedule->command('command:sent_mail_event')->cron('0 8 * * *');
        $schedule->command('command:add_day_off_moth')->cron('* * 1 * *');
        $schedule->command('command:move_day_off_end_year')->cron('45 23 31 12 *');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
