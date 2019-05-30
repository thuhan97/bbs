<?php

namespace App\Console\Commands;

use App\Events\PostNotify;
use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PostNotificationSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:post-notice';

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
        $posts = Post::where('has_notify', 1)
            ->where('is_sent', 0)->where('notify_date', '<=', Carbon::now())
            ->get();
//        $posts = Post::all();
        $users = User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
        $notifications = [];
        foreach ($posts as $post) {
            foreach ($users as $user_id) {
                $notifications[] =
                    NotificationHelper::generateNotify($user_id, 'Thông báo', $post->name, 0, NOTIFICATION_TYPE['post'], route('post_detail', $post->id));
            }
            broadcast(new PostNotify($post));
            $post->is_sent = 1;
            $post->save();
        }
        if (count($notifications) > 0) {
            Notification::insertAll($notifications);
        }

    }
}
