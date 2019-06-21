<?php

namespace App\Console\Commands;

use App\Helpers\NotificationHelper;
use App\Models\User;
use Illuminate\Console\Command;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test {--title=} {--content=} {--url=}';

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
        $title = $this->option('title') ?? 'Test';
        $content = $this->option('content') ?? 'Test messages.';
        $url = $this->option('url');

        $users = User::select('id', 'name', 'last_activity_at')
            ->where('status', ACTIVE_STATUS)
            ->has('firebase_tokens')
            ->with('firebase_tokens')
            ->get();

        foreach ($users as $user) {
            $devices = [];
            foreach ($user->firebase_tokens as $firebase_token) {
                $devices[] = $firebase_token->token;
            }
            if (!empty($devices)) {
                NotificationHelper::sendPushNotification($devices, $title, $content, $url);
            }
        }
    }
}
