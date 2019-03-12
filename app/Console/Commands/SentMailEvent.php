<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use App\Events\EventSentMail;
use App\Repositories\Contracts\IEventRepository;

class SentMailEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sent_mail_event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command sent mail event';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IEventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $event = $this->eventRepository->findEventDatePushNotification();
        $eventCount = count($event);
        if ($eventCount > 0) {
            foreach ($event as $key => $eventValue) {
                if ($eventValue != null) {
                    event(new EventSentMail($eventValue));
                    $eventValue->is_sent = Event::IS_SENT;
                    $eventValue->save();
                }
            }
        }
    }
}
