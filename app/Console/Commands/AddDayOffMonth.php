<?php

namespace App\Console\Commands;

use App\Models\RemainDayoff;
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
        $users=User::where('contract_type',CONTRACT_TYPES['staff'])->whereNull('end_date')->get();
        foreach ($users as $user){
            $dayOffRemain=DB::table('remain_dayoffs')->where('year', '=', date('Y'))
                ->where('user_id',$user->id);
            if ($dayOffRemain->first()){
                $dayOffRemain=$dayOffRemain->increment('active', 1);
            }else{
                $dayOffRemain=new RemainDayoff();
                $dayOffRemain->user_id=$user->id;
                $dayOffRemain->year=date('Y');
                $dayOffRemain->save();
            }
        }

    }

}
