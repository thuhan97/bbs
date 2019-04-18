<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recur;
use App\Models\Booking;

class BookingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new booking follow recur';

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
         $recurs= Recur::all();
            foreach ($recurs as $recur) {
               if($recur->repeat_type==1){
                   $add=true;
                }
               else if($recur->repeat_type==2){
                if($recur->days_repeat==\Carbon::now()->day)
                   $add=true;
               }
               else{
                if($recur->days_repeat==\Carbon::now()->format('m-d'))
                    $add=true;
               }
               if(isset($add)&&$add==true){
                    $booking=[
                            'title'=>$recur->title,
                            'content'=>$recur->content,
                            'users_id'=>$recur->users_id,
                            'meetings_id'=>$recur->meetings_id,
                            'start_date'=>\Carbon::now()->format('Y-m-d').' '.$recur->start_time,
                            'end_date'=>\Carbon::now()->format('Y-m-d').' '.$recur->end_time,
                            'participants'=>$recur->participants,
                            'is_notify'=>$recur->is_notify,
                            'color'=>$recur->color,
                        ];
                    \DB::table('bookings')->insert($booking);
               }
            }
    }
}
