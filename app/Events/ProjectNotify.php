<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;
use App\Models\Notification;

class ProjectNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project,$userIds)
    {
        $url = route('project_detail', ['id' => $project->id]);
        $title = Auth::user()->name .SPACE.__l('create_project').SPACE.$project->name;
        $content = $project->description;
        $notifications=[];
        foreach ($userIds as $user_id) {
            if ($project->leader_id == $user_id) continue;
            $notifications[] =
                NotificationHelper::generateNotify($user_id, $title, $content, Auth::id(), NOTIFICATION_TYPE['project'], $url);
        }
        Notification::insertAll($notifications);
        $this->data = [
            'id' => $project->id,
            'title' => $title,
            'content' => $content,
            'image_url' => Auth::user()->avatar,
            'logo_url' => NOTIFICATION_LOGO[NOTIFICATION_TYPE['project']],
            'logo_id' => NOTIFICATION_TYPE['project'],
            'url' => $url,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('bbs');
    }
}
