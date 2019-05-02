<?php

namespace App\Console\Commands;

use App\Models\RemainDayoff;
use App\Models\User;
use Illuminate\Console\Command;
class MoveDayOffEndYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:move_day_off_end_year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move day off end year';

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
            $dayOffRemainPreYear=RemainDayoff::where('year', '=', ((int)date('Y'))- PRE_YEAR)->where('user_id',$user->id);
            $dayOffRemainYear=RemainDayoff::where('year', '=', date('Y'))->where('user_id',$user->id);

            //calculate day off end year
            if (isset($dayOffRemainPreYear) && isset($dayOffRemainYear) && $dayOffRemainPreYear->remain > DAY_OFF_DEFAULT){
                $dayOffRemainYear->remain_pre_year=$dayOffRemainPreYear->remain;
                $dayOffRemainYear->save();
            }
            // create remain day off current year
            RemainDayoff::create([
                'user_id'=>$user->id,
                'year'=>(int)date('Y')+NEXT_YEAR,
                'remain'=>ADD_DAY_OFF_MONTH,
                'remain_increment'=>ADD_DAY_OFF_MONTH,
            ]);
        }

    }

}
