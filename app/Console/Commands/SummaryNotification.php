<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SummaryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:summary {--any=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (env('ENABLE_PUSH_NOTIFY')) {
            $anyTime = $this->option('any');
            if ($anyTime)
                $intervalTime = 1;
            else
                $intervalTime = NOTIFICATION_REPEAT_MINUTE;
            
            $users = User::select('id', 'name', 'last_activity_at')
                ->where('status', ACTIVE_STATUS)
                ->where('last_activity_at', '<=', Carbon::now()->subMinute($intervalTime))
                ->has('firebase_tokens')
                ->with('firebase_tokens')
                ->has('unread_notifications', '>', 0)
                ->withCount('unread_notifications')
                ->get();

            foreach ($users as $user) {
                $devices = [];
                foreach ($user->firebase_tokens as $firebase_token) {
                    if ($anyTime || $firebase_token->push_at == null || $firebase_token->push_at <= Carbon::now()->subMinute($intervalTime)) {
                        $devices[] = $firebase_token->token;
                        $firebase_token->push_at = Carbon::now();
                        $firebase_token->save();
                    }
                }
                if (!empty($devices)) {
                    $content = "Bạn có $user->unread_notifications_count thông báo chưa đọc.";
                    NotificationHelper::sendPushNotification($devices, '[' . env('APP_NAME') . ']', $content);
                }
            }
        }
    }
}
