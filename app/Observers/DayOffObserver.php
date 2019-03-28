<?php

namespace App\Observers;

use App\Models\DayOff;

class DayOffObserver
{
    /**
     * Handle the event "creating" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function creating(DayOff $dayOff)
    {
//        $dayOff->number_off = DateTimeFacade::getDayOffNumbers($dayOff->start_at, $dayOff->end_at);
    }

    /**
     * Handle the event "created" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function created(DayOff $dayOff)
    {
        //
    }

    /**
     * Handle the event "updating" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function updating(DayOff $dayOff)
    {
//        $dayOff->number_off = DateTimeFacade::getDayOffNumbers($dayOff->start_at, $dayOff->end_at);
    }

    /**
     * Handle the event "updated" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function updated(DayOff $dayOff)
    {
        //
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function deleted(DayOff $dayOff)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function restored(DayOff $dayOff)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param DayOff $dayOff
     *
     * @return void
     */
    public function forceDeleted(DayOff $dayOff)
    {
        //
    }
}
