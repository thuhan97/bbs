<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 10:04 AM
 */

namespace App\Services;

use App\Events\PostNotify;
use App\Events\ReportReplyNoticeEvent;
use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\Report;
use App\Models\ReportReceiver;
use App\Models\ReportReply;
use App\Models\User;
use App\Services\Contracts\IUserTeamService;

class NotificationService extends AbstractService implements IUserTeamService
{
    public function __construct()
    {

    }

    public function sentReportNotification($reportId, $currentUser, $content)
    {
        $report = Report::find($reportId);
        //get receiverId
        $receiverIds = ReportReceiver::select('user_id')->where('report_id', $reportId);
        //get reply Id
        $relationIds = ReportReply::select('user_id')->where('report_id', $reportId)
            ->union($receiverIds)
            ->pluck('user_id')->toArray();

        $relationIds[] = $report->user_id;

        foreach (array_unique($relationIds) as $userId) {
            if ($userId != $currentUser->id) {
                event(new ReportReplyNoticeEvent($currentUser, $userId, $report, $content));
            }
        }

    }

    public function sendPostNotification($posts)
    {
        $users = User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
        $notifications = [];
        foreach ($posts as $post) {
            foreach ($users as $user_id) {
                $notifications[] =
                    NotificationHelper::generateNotify($user_id, 'Thông báo', $post->name, 0, NOTIFICATION_TYPE['post'], route('post_detail', $post->id));
            }
            broadcast(new PostNotify($post));
            $post->is_sent = 1;
            $post->save();
        }

        $this->insertNotification($notifications);
    }

    public function sendRegularNotification($regulation)
    {
        $users = User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
        $notifications = [];
        foreach ($users as $user_id) {
            $notifications[] =
                NotificationHelper::generateNotify($user_id, 'Nội quy & Quy định', 'Cập nhật ' . $regulation->name, 0,
                    NOTIFICATION_TYPE['post'], route('regulation_detail', $regulation->id));
        }
//        broadcast(new PostNotify($post));

        $this->insertNotification($notifications);
    }

    public function insertNotification($notifications)
    {
        if (count($notifications) > 0) {
            Notification::insertAll($notifications);
        }
    }

}
