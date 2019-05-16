<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    /**
     * Handle the Punish "updating" event.
     *
     * @param Report $report
     *
     * @return void
     */
    public function creating(Report $report)
    {
        if (Auth::check()) {
            $team = Auth::user()->team();

            if ($team) {
                $report->team_id = $team->id;
                $report->group_id = $team->group_id;
            }
        }
    }
}
