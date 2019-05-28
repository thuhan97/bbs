<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Report $report)
    {
        $week = get_week_number();
        return $user->id === $report->user_id && ($report->week_num == $week || $report->report_date == date(DATE_FORMAT));
    }
}
