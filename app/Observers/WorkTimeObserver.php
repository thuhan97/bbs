<?php

namespace App\Observers;

use App\Models\WorkTime;

class WorkTimeObserver
{
    /**
     * Handle the worktime "updating" event.
     *
     * @param WorkTime $workTime
     *
     * @return void
     */
    public function updating(WorkTime $workTime)
    {
        $workTime->note = WorkTime::WORK_TIME_CALENDAR_DISPLAY[$workTime->type] ?? '';
    }
}
