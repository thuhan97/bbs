<?php

namespace App\Listeners;

use App\Events\EventSentMail;
use App\Facades\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EventSendMail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
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
    public function handle(EventSentMail $event)
    {
        $mail = new \App\Mail\EventSendMail($event);
        $email = "tuanhung.jvb@gmail.com";
        SendMail::sentMail($mail, $email);
    }
}
