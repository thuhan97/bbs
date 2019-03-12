<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class EventSendMail extends BaseMailer
{
    const BODY_TEMPLATE = 'emails.event.notify_event';

    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {

        $this->data = $data->event;
        $mailSubject = '[' . 'Sự kiện' . ']' . ' - ' . $this->data->name;
        parent::__construct(['event' => $this->data], self::BODY_TEMPLATE, $mailSubject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        parent::sendMail();
    }
}
