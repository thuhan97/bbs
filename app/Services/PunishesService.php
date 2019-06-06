<?php
/**
 * PunishesService class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */

namespace App\Services;

use App\Models\Config;
use App\Models\Punishes;
use App\Models\Rules;
use App\Models\WorkTime;
use App\Services\Contracts\IPunishesService;
use Illuminate\Support\Facades\DB;

/**
 * @property Config                                            config
 * @property \Illuminate\Database\Eloquent\Collection|static[] rules
 * @property NotificationService                               notificationService
 */
class PunishesService extends AbstractService implements IPunishesService
{
    public function __construct()
    {
        $this->config = Config::first();
        $this->rules = Rules::all();
        $this->notificationService = app()->make(NotificationService::class);
    }

    const THOUSAND_UNIT = 1000;

    public function calculateLateTime($year, $month, $userIds = [])
    {
        [$firstDate, $endDate] = getStartAndEndDateOfMonth($month, $year);

        //read config file
        $path = storage_path('app/' . $this->config->late_time_rule_json ?? LATE_MONEY_CONFIG); // ie: /var/www/laravel/app/storage/json/filename.json

        $configs = collect(json_decode(file_get_contents($path), true)['configs']);

        $freeCount = $configs->where('free', true)->count();
        $aioConfigs = $configs->where('aio', '!=', 0);
        $eachConfigs = $configs->where('free', false)->where('aio', 0);

        //get late list
        $model = WorkTime::whereIn('type', [
            WorkTime::TYPES['lately'],
            WorkTime::TYPES['lately_ot'],
        ])
            ->whereDate('work_day', '>=', $firstDate)
            ->whereDate('work_day', '<=', $endDate);

        if (!empty($userIds)) $model->whereIn('user_id', $userIds);

        $lateList = $model->orderBy('work_day')
            ->get()->groupBy('user_id');

        DB::beginTransaction();
        //clear old data
        $punish = Punishes::where('rule_id', LATE_RULE_ID)
            ->whereDate('infringe_date', '>=', $firstDate)
            ->whereDate('infringe_date', '<=', $endDate);
        if (!empty($userIds))
            $punish->whereIn('user_id', $userIds);

        $punish->forceDelete();
        $addPunishes = [];
        //caculate
        foreach ($lateList as $user_id => $workTimes) {

            $lateCount = $workTimes->count();
            if ($lateCount > $freeCount) {
                //start caculate
                if ($lateCount > $aioConfigs->min('name')) {
                    //Vé tháng
                    $aio = $aioConfigs->sortByDesc('name')->firstWhere('name', '<=', $lateCount);
                    if ($aio) {
                        $date = $workTimes->max('work_day');
                        $addPunishes[] = [
                            'rule_id' => LATE_RULE_ID,
                            'user_id' => $user_id,
                            'infringe_date' => $date,
                            'total_money' => $aio['aio'] * self::THOUSAND_UNIT,
                            'detail' => __l('punish_late_money_aio', [
                                'number' => $lateCount,
                                'month' => $month,
                            ])
                        ];
                    }
                } else {
                    foreach ($workTimes as $idx => $workTime) {
                        if ($idx < $freeCount) continue;
                        $number = $idx + 1;
                        $config = $eachConfigs->firstWhere('name', $number);
                        if ($config) {
                            $times = collect($config['times']);
                            $time = $times->where('start', '<=', $workTime->start_at)
                                ->where('end', '>=', $workTime->start_at)
                                ->first();
                            if ($time) {
                                $addPunishes[] = [
                                    'rule_id' => LATE_RULE_ID,
                                    'user_id' => $user_id,
                                    'infringe_date' => $workTime->work_day,
                                    'total_money' => $time['total'] * self::THOUSAND_UNIT,
                                    'detail' => __l('punish_late_money', [
                                        'number' => $number,
                                        'check_in' => date('h:i', strtotime($workTime->start_at)),
                                        'month' => $month,
                                    ])
                                ];
                            }
                        }

                    }
                }
            }
        }
        Punishes::insertAll($addPunishes);
        DB::commit();
    }

    /**
     * @param $day
     * @param $userIds
     */
    public function noWeeklyReport($day, $week, $users)
    {
        $weeklyReportRule = $this->rules->firstWhere('id', WEEKLY_REPORT_RULE_ID);
        if ($weeklyReportRule) {
            $penalize = $weeklyReportRule->penalize;

            $punishes = [];
            foreach ($users as $user) {
                $punishes[] = [
                    'rule_id' => LATE_RULE_ID,
                    'user_id' => $user->id,
                    'infringe_date' => $day,
                    'total_money' => $penalize,
                    'detail' => __l('weekly_report_punish', [
                        'day' => $day,
                        'week' => $week,
                    ])
                ];

                //notification
            }
            $this->notificationService->dontSentWeeklyReport($users, $day, $week);
            Punishes::insertAll($punishes);

        }
    }
}
