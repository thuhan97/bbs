<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recur;
use App\Models\Meeting;

class MeetingCommand extends Command
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
         $recurs= Recur::where('date'<=\Carbon::now()->format('Y-m-d'));
            foreach ($recurs as $recur) {
                $type=$recur->repeat_type;
                $days=$recur->days_repeat;
                if(($type==WEEKLY &&$days==\Carbon::now()->dayOfWeek) ||
                    ($type==MONTHLY &&$days==\Carbon::now()->day) ||
                    ($type==YEARLY && $days==\Carbon::now()->format('m-d')))
                        $add=1;

               if(isset($add)&&$add==1){
                    $booking=[
                            'title'=>$recur->title,
                            'content'=>$recur->content,
                            'users_id'=>$recur->users_id,
                            'meeting_room_id'=>$recur->meeting_room_id,
                            'start_time'=>$recur->start_time,
                            'end_time'=>$recur->end_time,
                            'date'=>\Carbon::now()->format('Y-m-d'),
                            'participants'=>$recur->participants,
                            'is_notify'=>$recur->is_notify,
                            'color'=>$recur->color,
                        ];
                    \DB::table('bookings')->insert($booking);
               }
            }
    }
}
