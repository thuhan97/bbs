<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * @property NotificationService notificationService
 */
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

        $this->notificationService = app()->make(NotificationService::class);
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

        $this->notificationService->sendPostNotification($posts);

    }
}
