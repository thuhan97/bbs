<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 10:04 AM
 */

namespace App\Services;

use App\Events\AskPermissionNoticeEvent;
use App\Events\DontReportNotice;
use App\Events\PostNotify;
use App\Events\ReportReplyNoticeEvent;
use App\Events\WorkExperienceNoticeEvent;
use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Models\Report;
use App\Models\ReportReceiver;
use App\Models\ReportReply;
use App\Models\User;
use App\Services\Contracts\IUserTeamService;
use Illuminate\Support\Facades\Auth;

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

    public function sendWorkExperience($workExperience)
    {
        $users = User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
        $notifications = [];

        foreach ($users as $user_id) {
            if ($user_id != $workExperience->creator_id) {
                $notifications[] =
                    NotificationHelper::generateNotify($user_id, $workExperience->user->name . SPACE . __l('word_title_notify'), $workExperience->introduction, $workExperience->creator_id, NOTIFICATION_TYPE['share'], route('view_experience', $workExperience->id));
            }
        }
        broadcast(new WorkExperienceNoticeEvent($workExperience))->toOthers();
        $this->insertNotification($notifications);
    }
    public function sendAskPermission($data,$type)
    {
        $url=route('ask_permission').'#ask-permission-'.$data->id;
        if ($type == WORK_TIME_TYPE[1]){
            $content=$data->note;
            $title=__l('ask').SPACE.mb_strtolower(WORK_TIME_TYPE[1],UTF_8);
        }elseif ($type == WORK_TIME_TYPE[2]){
            $content=$data->note;
            $title=__l('ask').SPACE.mb_strtolower(WORK_TIME_TYPE[2],UTF_8);
        }else{
            $content=$data->reason;
            $title=__l('ask_ot');
            $url=route('ask_permission').'#ot-'.$data->id;
        }
        $users = User::where('jobtitle_id','>', TEAMLEADER_ROLE)->pluck('id')->toArray();
        $notifications = [];

        foreach ($users as $user_id) {
            if ($users != Auth::id())
                $notifications[] = NotificationHelper::generateNotify($user_id,  ($data->user->name ?? $data->creator->name).SPACE.$title,$content, $data->creator_id ?? $data->user_id , NOTIFICATION_TYPE['day_off_create'], $url);
        }
        broadcast(new AskPermissionNoticeEvent($data,$title,$url,$content));
        $this->insertNotification($notifications);
    }

    public function sendRegularNotification($regulation)
    {
        $users = User::where('status', ACTIVE_STATUS)->pluck('id')->toArray();
        $notifications = [];
        foreach ($users as $user_id) {
            $notifications[] =
                NotificationHelper::generateNotify($user_id, __l('regulation'), 'Cập nhật ' . $regulation->name, 0,
                    NOTIFICATION_TYPE['post'], route('regulation_detail', $regulation->id));
        }
//        broadcast(new PostNotify($post));

        $this->insertNotification($notifications);
    }

    public function dontSentWeeklyReport($users, $day, $week)
    {
        $title = __l("Report");
        $notifications = [];
        $reportUrl = route('report');
        $createReportUrl = route('create_report');
        $message = __l('no_weekly_report', ['week' => $week]);
        foreach ($users as $user) {
            //toUser
            $notifications[] =
                NotificationHelper::generateNotify($user->id, $title, $message, 0,
                    NOTIFICATION_TYPE['report'], $createReportUrl);

            event(new DontReportNotice($user->id, $title, $message, $createReportUrl));
            //to manager
            $team = $user->team();
            if ($team) {
                $manageMessage = __l('staff_no_weekly_report', ['name' => $user->name, 'week' => $week]);
                $notifications[] =
                    NotificationHelper::generateNotify($team->leader_id, $title, $manageMessage, 0,
                        NOTIFICATION_TYPE['report'], $reportUrl);

                event(new DontReportNotice($team->leader_id, $title, $manageMessage, $reportUrl));
            }
        }

        $this->insertNotification($notifications);
    }

    public function insertNotification($notifications)
    {
        if (count($notifications) > 0) {
            Notification::insertAll($notifications);
        }
    }

}
