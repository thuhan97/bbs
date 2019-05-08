<?php

namespace App\Console\Commands;

use App\Helpers\DateTimeHelper;
use App\Models\CalendarOff;
use Illuminate\Console\Command;

class HolidayAutoAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:holiday';

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
        $calendarOffs = CalendarOff::where('is_repeat', CalendarOff::REPEAT)
            ->whereDate('date_off_from', '<', date(DATE_FORMAT))
            ->get();
        foreach ($calendarOffs as $calendarOff){
            $calendarOff->date_off_from = DateTimeHelper::getDateNextYear($calendarOff->date_off_from);
            $calendarOff->date_off_to = DateTimeHelper::getDateNextYear($calendarOff->date_off_to);

            $calendarOff->save();
        }

    }


}
