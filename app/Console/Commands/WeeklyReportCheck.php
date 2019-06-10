<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\PunishesService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WeeklyReportCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-report:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new booking follow bookings';
    /**
     * @var PunishesService
     */
    private $punishesService;

    /**
     * Create a new command instance.
     *
     * @param PunishesService $punishesService
     */
    public function __construct(PunishesService $punishesService)
    {
        parent::__construct();
        $this->punishesService = $punishesService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();
        $day = (int)$now->format('N');
        //Saturday
        if ($day == 6) return;

        $dayFormat = $now->format(DATE_FORMAT);
        $week = (int)$now->format('W');
        //check last week
        if ($day != 7) {
            $week--;
        }

        $monday = date(DATE_FORMAT, strtotime('monday last week'));
        $mondayD = Carbon::createFromFormat(DATE_FORMAT, $monday);

        //sql select
        $users = User::select('id', 'name', 'jobtitle_id', 'is_remote')
            ->where('status', ACTIVE_STATUS)
            ->where('jobtitle_id', '<', TEAMLEADER_ROLE)
            ->where(function ($q) {
                $q->whereNull('is_remote')->orWhere('is_remote', 0);
            })
            ->whereDoesntHave('reports', function ($q) use ($week, $mondayD) {

                $q->where('year', $mondayD->year)
                    ->where('month', $mondayD->month)
                    ->where('week_num', $week)
                    ->whereNull('report_date');
            })
            ->get();

        $this->punishesService->noWeeklyReport($dayFormat, $week, $users);
    }
}
