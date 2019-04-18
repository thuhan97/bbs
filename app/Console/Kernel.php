<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SentMailEvent;
use App\Console\Commands\BookingCommand;

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
        BookingCommand::class,
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
        //Hệ thống tự động checkDB và thêm phòng họp vào lịch lúc 05:00 hằng ngày
       $schedule->command('booking:create')->dailyAt('05:00');
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
