<?php


namespace App\Helpers;


use App\Models\Notification;

class NotificationHelper
{
    public static function generateNotify($toId, $title, $content, $fromId, $logoId, $url)
    {
        return [
            'id' => Notification::generateUID(),
            'user_id' => $toId,
            'logo_id' => $logoId,
            'sender_id' => $fromId,
            'title' => $title,
            'content' => $content,
            'data' => $url,
        ];
    }
}
