<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class StatisticeDayOffYearEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:statistice_day_off_year_end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command statistice day off year end';

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
        $users=User::all();
        foreach ($users as $user){

        }
    }
}
