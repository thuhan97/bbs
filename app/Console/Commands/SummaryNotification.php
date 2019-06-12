<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\User;
use Illuminate\Console\Command;

class SummaryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:summary';

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
        $users = User::select('id', 'name')
            ->where('status', ACTIVE_STATUS)
            ->has('active_firebase_tokens')
            ->with('active_firebase_tokens:user_id,token')
            ->has('unread_notifications', '>', 0)
            ->withCount('unread_notifications')
            ->get();
        foreach ($users as $user) {
            $deviceTokens = $user->active_firebase_tokens->pluck('token')->toArray();
            $content = "Bạn có $user->unread_notifications_count thông báo chưa đọc.";
            NotificationHelper::sendPushNotification($deviceTokens, '[' . env('APP_NAME') . ']', $content);
        }
    }
}
