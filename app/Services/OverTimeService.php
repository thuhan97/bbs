<?php
/**
 * OverTimeService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

use App\Models\WorkTimesExplanation;
use App\Services\Contracts\IOverTimeService;

class OverTimeService extends AbstractService implements IOverTimeService
{
    public function getListOverTime()
    {
        return WorkTimesExplanation::select(
            'work_times_explanation.work_day', 'work_times_explanation.type',
            'work_times_explanation.ot_type', 'work_times_explanation.note',
            'work_times_explanation.user_id', 'ot_times.creator_id', 'ot_times.id as id_ot_time', 'ot_times.status',
            'ot_times.approver_id', 'users.staff_code', 'users.name as approver', 'work_times.end_at as work_time_end_at')
            ->leftJoin('work_times', function ($join) {
                $join->on('work_times.user_id', '=', 'work_times_explanation.user_id')
                    ->on('work_times.work_day', '=', 'work_times_explanation.work_day');
            })
            ->leftJoin('ot_times', function ($join) {
                $join->on('ot_times.creator_id', '=', 'work_times_explanation.user_id')
                    ->on('ot_times.work_day', '=', 'work_times_explanation.work_day');
            })->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'ot_times.approver_id');
            })
            ->whereYear('work_times_explanation.work_day', date('Y'))
            ->groupBy('work_times_explanation.work_day', 'work_times_explanation.type',
                'work_times_explanation.ot_type', 'work_times_explanation.note', 'work_times_explanation.user_id', 'ot_times.creator_id')
            ->orderBy('work_times_explanation.work_day', 'desc')
            ->get();
    }
}
