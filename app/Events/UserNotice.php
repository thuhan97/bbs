<?php

namespace App\Events;

use App\Helpers\NotificationHelper;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userId;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param $userId
     * @param $message
     */
    public function __construct($user, $title, $content, $url, $withFirebase = true)
    {
        $this->userId = $user->id;
        $this->data = [
            'title' => $title,
            'content' => $content,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['post']],
            'logo_id' => NOTIFICATION_TYPE['post'],
            'url' => $url,
        ];

        if ($withFirebase) {
            $devices = [];
            foreach ($user->firebase_tokens as $firebase_token) {
                $devices[] = $firebase_token->token;
            }
            if (!empty($devices)) {
                NotificationHelper::sendPushNotification($devices, $title, $content, $url);
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->userId);
    }
}
