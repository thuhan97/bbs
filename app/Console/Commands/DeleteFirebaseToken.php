<?php

namespace App\Console\Commands;

use App\Models\UserFirebaseToken;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteFirebaseToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:clear_old_device';

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
        //delete token over 1 month
        $now = Carbon::now();
        UserFirebaseToken::where('last_activity_at', '<=', $now->subMonth())->delete();

    }
}
