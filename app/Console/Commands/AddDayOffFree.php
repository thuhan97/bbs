<?php

namespace App\Console\Commands;

use App\Models\RemainDayoff;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddDayOffFree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add_day_off_free';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add one day off free if female and staff';

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
        $users=User::whereIn('contract_type',[CONTRACT_TYPES['staff'],CONTRACT_TYPES['probation']])->where('status',ACTIVE_STATUS)->whereNull('end_date')->where('sex',SEX['female'])->get();
        foreach ($users as $user){
            $dayOffRemain=RemainDayoff::where('year', '=', date('Y'))
                ->where('user_id',$user->id);
            if ($dayOffRemain->first()){
                $data=['day_off_free_female' => REMAIN_DAY_OFF_DEFAULT];
                $dayOffRemain=$dayOffRemain->update($data);

            }

        }

    }

}
