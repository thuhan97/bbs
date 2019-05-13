<?php

namespace App\Observers;

use App\Models\WorkTime;
use App\Services\WorkTimeService;

/**
 * @property mixed workTimeService
 */
class WorkTimeObserver
{

    public function __construct()
    {
        $this->workTimeService = app()->make(WorkTimeService::class);
    }

    /**
     * Handle the worktime "updating" event.
     *
     * @param WorkTime $workTime
     *
     * @return void
     */
    public function updating(WorkTime $workTime)
    {
        $date = date_create_from_format(DATE_FORMAT, $workTime->work_day);
        [$startDate, $endDate] = getStartAndEndDateOfMonth($date->format('m'), $date->format('Y'));
        $this->workTimeService->calculateLateTime($startDate, $endDate, [$workTime->user_id]);
    }
}
