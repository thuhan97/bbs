<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\CalendarOff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WeeklyReportReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-report:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notice to send weekly report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $date = $now->format(DATE_FORMAT);
        $calendarOffs = CalendarOff::all();
        //check is holiday
        if ($calendarOffs->where('date_off_from', '<=', $date)->where('date_off_to', '>=', $date)->first()) {
            return;
        }

        $users = User::select('id', 'name', 'last_activity_at')
            ->where('status', ACTIVE_STATUS)
            ->where('jobtitle_id', '<', TEAMLEADER_ROLE)
            ->has('firebase_tokens')
            ->with('firebase_tokens')
            ->get();

        foreach ($users as $user) {
            $devices = [];
            foreach ($user->firebase_tokens as $firebase_token) {
                if ($firebase_token->push_at <= Carbon::now()->subMinute(10)) {
                    $devices[] = $firebase_token->token;
                }
            }
            if (!empty($devices)) {
                $content = "Gửi báo cáo tuần ngay đi nào. \nHave a nice weekend!";
                NotificationHelper::sendPushNotification($devices, '[' . env('APP_NAME') . ']', $content, route('create_report'));
            }
        }
    }
}
