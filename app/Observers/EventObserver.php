<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver
{
    /**
     * Handle the event "creating" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function creating(Event $event)
    {
        $event->name_slug = str_slug($event->name);
    }

    /**
     * Handle the event "created" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function created(Event $event)
    {
        //
    }

    /**
     * Handle the event "updating" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function updating(Event $event)
    {
    }

    /**
     * Handle the event "updated" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
