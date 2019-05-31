<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuggestionNotifyEvent extends NotificationBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    private $record;
    private $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($record, $user)
    {
        $this->record = $record;
        $this->user = $user;
        $url = route('list_suggestions');
        $this->data = [
            'id' => $this->record->id,
            'name' => $this->user->name,
            'title' => $this->user->name .SPACE .SUGGESTIONS_TITLE_NOTIFY,
            'content' => $this->record->comment,
            'image_url' => $this->user->avatar,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['suggestions']],
            'logo_id' => NOTIFICATION_TYPE['suggestions'],
            'url' => $url,
            'from_id' => $this->record->creator_id,
            'to_id' => $this->record->isseus_id,
        ];

        parent::__construct();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->record->isseus_id);
    }
}
