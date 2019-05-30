<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/23/2019
 * Time: 10:04 AM
 */

namespace App\Services;

use App\Events\ReportReplyNoticeEvent;
use App\Models\Report;
use App\Models\ReportReceiver;
use App\Models\ReportReply;
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
                event(new ReportReplyNoticeEvent($currentUser, $userId, $reportId, $content));
            }
        }

    }


}
