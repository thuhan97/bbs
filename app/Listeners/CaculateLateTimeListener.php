<?php

namespace App\Listeners;

use App\Events\CaculateLateTimeEvent as CaculateLateTimeEventAlias;
use App\Services\Contracts\IWorkTimeService;

class CaculateLateTimeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     *
     * @return void
     */
    public function handle(CaculateLateTimeEventAlias $event)
    {
        /** @var IWorkTimeService $workTimeService */
        $workTimeService = app()->make(IWorkTimeService::class);
        $workTimeService->calculateLateTime($event->startDate, $event->endDate, $event->userIds);
    }
}
