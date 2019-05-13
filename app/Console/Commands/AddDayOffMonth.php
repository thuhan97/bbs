<?php

namespace App\Console\Commands;

use App\Models\RemainDayoff;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddDayOffMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add_day_off_moth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'plus monthly holidays';

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
        $users=User::whereIn('contract_type',[CONTRACT_TYPES['staff'],CONTRACT_TYPES['probation']])->where('status',ACTIVE_STATUS)->whereNull('end_date')->get();
        foreach ($users as $user){
            $dayOffRemain=RemainDayoff::where('year', '=', date('Y'))
                ->where('user_id',$user->id);

            if ($dayOffRemain->first()){
                $data=[
                    'remain' => \DB::raw( 'remain + 1' ), // increment
                    'remain_increment' => \DB::raw( 'remain_increment + 1' ), // increment
                ];
                $dayOffRemain=$dayOffRemain->update($data);

            }

        }

    }

}
