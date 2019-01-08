<?php

namespace App\Listeners;

use App\Events\SearchEvent;
use App\Models\SearchLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteSearchLog implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  object $event
     *
     * @return void
     */
    public function handle(SearchEvent $event)
    {
        $log = SearchLog::where('keyword', $event->keyword)->first();

        if (!$log) {
            $log = new SearchLog();
            $log->fill([
                'keyword' => $event->keyword
            ]);
        } else {
            $log->count++;
        }
        $log->save();
    }
}
