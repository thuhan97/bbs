<?php

namespace App\Console;

use App\Console\Commands\AddDayOffFree;
use App\Console\Commands\AddDayOffMonth;
use App\Console\Commands\DeleteFirebaseToken;
use App\Console\Commands\HolidayAutoAdd;
use App\Console\Commands\MeetingCommand;
use App\Console\Commands\MoveDayOffEndYear;
use App\Console\Commands\PostNotificationSender;
use App\Console\Commands\SentMailEvent;
use App\Console\Commands\SummaryNotification;
use App\Console\Commands\WeeklyReportCheck;
use App\Console\Commands\WeeklyReportReminder;
use Illuminate\Console\Scheduling\Schedule;
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
        MoveDayOffEndYear::class,
        HolidayAutoAdd::class,
        AddDayOffFree::class,
        PostNotificationSender::class,
        MeetingCommand::class,
        WeeklyReportCheck::class,
        WeeklyReportReminder::class,
        SummaryNotification::class,
        DeleteFirebaseToken::class,
    );

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Hện thống sẽ tự động check DB và gửi mail lúc 8h sáng
        $schedule->command('command:sent_mail_event')->cron('0 8 * * *');
        $schedule->command('command:add_day_off_moth')->cron('59 23 15 * *');
        //Hệ thống tự động checkDB và thêm phòng họp vào lịch lúc 05:00 hằng ngày
        $schedule->command('meeting:create')->dailyAt('00:01');
        $schedule->command('command:add_day_off_moth')->cron('* * 1 * *');
        $schedule->command('command:move_day_off_end_year')->cron('45 23 31 12 *');
        $schedule->command('command:add_day_off_free')->cron('* * 1 * *');
        $schedule->command('command:holiday')->monthly();
        $schedule->command('cron:post-notice')->everyThirtyMinutes();
        $schedule->command('weekly-report:check')->dailyAt('12:00');
        //Nhắc nhở gửi báo cáo tuần vào lúc 17h15 ngày thứ 6 hàng tuần
        $schedule->command('weekly-report:reminder')->cron('15 17 * * 5');
        $schedule->command('notify:summary')->everyMinute();
        $schedule->command('notify:clear_old_device')->dailyAt('00:00');
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
