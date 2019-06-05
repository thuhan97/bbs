<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class MeetingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meeting:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new booking follow bookings';

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
        $bookings = Booking::where('date' <= \Carbon::now()->format('Y-m-d'));
        foreach ($bookings as $booking) {
            $type = $booking->repeat_type;
            $days = $booking->days_repeat;
            if (($type == WEEKLY && $days == \Carbon::now()->dayOfWeek) ||
                ($type == MONTHLY && $days == \Carbon::now()->day) ||
                ($type == YEARLY && $days == \Carbon::now()->format('m-d')))
                $add = 1;

            if (isset($add) && $add == 1) {
                $booking = [
                    'title' => $booking->title,
                    'content' => $booking->content,
                    'users_id' => $booking->users_id,
                    'meeting_room_id' => $booking->meeting_room_id,
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'date' => \Carbon::now()->format('Y-m-d'),
                    'participants' => $booking->participants,
                    'is_notify' => $booking->is_notify,
                    'color' => $booking->color,
                ];
                \DB::table('bookings')->insert($booking);
            }
        }
    }
}
