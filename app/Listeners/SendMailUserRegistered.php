<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Facades\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailUserRegistered implements ShouldQueue
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
    public function handle(UserRegistered $event)
    {
        $mail = new \App\Mail\UserRegistered($event->user);
        $email = $event->user->email;

        SendMail::sentMail($mail, $email);
    }
}
