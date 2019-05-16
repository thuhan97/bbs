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
     * Handle the worktime "creating" event.
     *
     * @param WorkTime $workTime
     *
     * @return void
     */
    public function creating(WorkTime $workTime)
    {
        $this->updatingData($workTime);
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
        $this->updatingData($workTime);
    }

    private function updatingData(WorkTime $workTime)
    {
        $workTimeData = $this->workTimeService->getWorkTime($workTime->user, date_create($workTime->work_day),
            date_create($workTime->start_at)->format('H:i'), date_create($workTime->end_at)->format('H:i'));

        if ($workTimeData) {
            $workTime->note = $workTimeData['note'];
            $workTime->type = $workTimeData['type'];
            $workTime->cost = $workTimeData['cost'];
        }
        $date = date_create_from_format(DATE_FORMAT, $workTime->work_day);
        [$startDate, $endDate] = getStartAndEndDateOfMonth($date->format('m'), $date->format('Y'));
        $this->workTimeService->calculateLateTime($startDate, $endDate, [$workTime->user_id]);
    }
}
