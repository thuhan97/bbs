<?php
/**
 * WorkTimeService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

use App\Models\AdditionalDate;
use App\Models\CalendarOff;
use App\Models\Config;
use App\Models\Punishes;
use App\Models\User;
use App\Models\WorkTime;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Services\Contracts\IWorkTimeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @property Config config
 */
class WorkTimeService extends AbstractService implements IWorkTimeService
{
    const LATE_UNIT = 1000;
    const LATE_SECON_SUFFIX = ':00'; //00 to 59

    private $calendarOffs;

    /**
     * WorkTimeService constructor.
     *
     * @param \App\Models\WorkTime                            $model
     * @param \App\Repositories\Contracts\IWorkTimeRepository $repository
     */
    public function __construct(WorkTime $model, IWorkTimeRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->config = Config::first();
        $this->calendarOffs = CalendarOff::all();
        $this->additionalDates = AdditionalDate::all();

        $this->users = User::select('id', 'name', 'staff_code', 'contract_type')->with('workTimeRegisters')->get();

    }

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string  $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search)
    {
        $model = $this->getSearchModel($request);
        return $model->search($search)->paginate($perPage);
    }

    /**
     * @param Request $request
     * @param         $search
     *
     * @return mixed
     */
    public function export(Request $request)
    {
        $search = $request->search;
        $model = $this->getSearchModel($request, true);
        return $model->search($search)->get();
    }

    public function deletes($startDate, $endDate)
    {
        WorkTime::whereDate('work_day', '>=', $startDate)
            ->whereDate('work_day', '<=', $endDate)
            ->delete();
    }

    public function importWorkTime($userCode, $staffCode, $work_day, $startAt, $endAt)
    {
        $userId = $userCode[$staffCode];
        $user = $this->users->firstWhere('id', $userId);

        $workTime = $this->getWorkTime($user, $work_day, $startAt, $endAt);
        if ($workTime) {
            $workTime['user_id'] = $userId;
            $workTime['work_day'] = $work_day->format(DATE_FORMAT_SLASH);
        }
        return $workTime;
    }

    /**
     * @param       $fromDate
     * @param       $toDate
     * @param array $userIds
     *
     * @return mixed
     */
    public function calculateLateTime($fromDate, $toDate, $userIds = [])
    {
        //read config file
        $path = storage_path('app/' . $this->config->late_time_rule_json ?? LATE_MONEY_CONFIG); // ie: /var/www/laravel/app/storage/json/filename.json

        $configs = collect(json_decode(file_get_contents($path), true)['configs']);

        $freeCount = $configs->where('free', true)->count();
        $aioConfigs = $configs->where('aio', '!=', 0);
        $eachConfigs = $configs->where('free', false)->where('aio', 0);

        //get late list
        $model = $this->model
            ->whereIn('type', [
                WorkTime::TYPES['lately'],
                WorkTime::TYPES['lately_ot'],
            ])
            ->whereDate('work_day', '>=', $fromDate)
            ->whereDate('work_day', '<=', $toDate);

        if (!empty($userIds)) $model->whereIn('id', $userIds);
        $lateList = $model->orderBy('work_day')
            ->get()->groupBy('user_id');

        DB::beginTransaction();
        //clear old data
        $punish = Punishes::where('rule_id', LATE_RULE_ID)
            ->whereDate('infringe_date', '>=', $fromDate)
            ->whereDate('infringe_date', '<=', $toDate);
        if (!empty($userIds))
            $punish->whereIn('id', $userIds);

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
                            'total_money' => $aio['aio'] * self::LATE_UNIT,
                            'detail' => __l('punish_late_money_aio', [
                                'number' => $lateCount,
                                'start_date' => $fromDate,
                                'to_date' => $toDate,
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
                                    'total_money' => $time['total'] * self::LATE_UNIT,
                                    'detail' => __l('punish_late_money', [
                                        'number' => $number,
                                        'check_in' => date('h:i', strtotime($workTime->start_at)),
                                        'month' => get_month($workTime->work_day),
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
     * @param $startAt
     * @param $endAt
     *
     * @return array
     */
    private function getWorkTime($user, $date, $startAt, $endAt)
    {
        if ($endAt == null && $startAt != null && $startAt > HAFT_AFTERNOON) {
            [$startAt, $endAt] = [$endAt, $startAt];
        }
        if (!$this->config->time_afternoon_go_late_at) throw new \Exception(__l('system_no_config_time'));
        $addData = false;
        $type = 0;
        $checkIsAdditionalDate = $this->additionalDates->firstWhere('date_add', $date->format(DATE_FORMAT));
        //
        $check = !$checkIsAdditionalDate && $this->calendarOffs->where('date_off_from', '>=', $date->format(DATE_FORMAT))->where('date_off_to', '<=', $date->format(DATE_FORMAT))->first();

        if ($check) {
            $type = WorkTime::TYPES['calendar_off'];
            return [
                'start_at' => null,
                'end_at' => null,
                'note' => WorkTime::WORK_TIME_CALENDAR_DISPLAY[$type] ?? '',
                'type' => $type,
            ];
        } else if (($this->config->work_days && in_array($date->format('N'), $this->config->work_days)) || !$this->config->work_days || $checkIsAdditionalDate) {
            //checkin in week
            //getworktime of user
            if (in_array($user->contract_type, [CONTRACT_TYPES['staff'], CONTRACT_TYPES['staff']])) {
                $addData = true;
                //check day is off
                if ($startAt == null && $endAt == null) {
                    $type = WorkTime::TYPES['off'];
                } else {
                    if ($startAt) {
                        if ($startAt >= $this->config->time_afternoon_go_late_at) {
                            $type += WorkTime::TYPES['lately'];
                        } else if ($startAt >= $this->config->time_morning_go_late_at) {
                            $type += WorkTime::TYPES['lately'];
                        }
                    }
                    if ($endAt) {
                        if ($endAt <= $this->config->morning_end_work_at) {
                            $type += WorkTime::TYPES['early'];
                        } else if ($endAt <= $this->config->afternoon_end_work_at) {
                            $type += WorkTime::TYPES['early'];
                        } else if ($this->config->time_ot_early_at && $endAt >= $this->config->time_ot_early_at) {
                            $type += WorkTime::TYPES['ot'];
                        }
                    }
                }
            } else {
                //check dayoff partime or internship
                $workTime = $user->workTimeRegisters->firstWhere('day', (int)$date->format('N') + 1);
                if ($workTime) {
                    //no register
                    if (!($workTime->start_at == OFF_TIME)) {
                        $addData = true;
                        if ($startAt == null && $endAt == null) {
                            $type = WorkTime::TYPES['off'];
                        } else {
                            if ($workTime->end_at <= SWITCH_TIME) {
                                //morning only. No OT, check morning lately and morning early
                                if ($startAt) {
                                    if ($startAt >= $this->config->time_morning_go_late_at) {
                                        $type += WorkTime::TYPES['lately'];
                                    }
                                }
                                if ($endAt) {
                                    if ($endAt <= $this->config->morning_end_work_at) {
                                        $type += WorkTime::TYPES['early'];
                                    }
                                }
                            } else if ($workTime->start_at >= SWITCH_TIME) { //afternoon only
                                if ($startAt) {
                                    if ($this->config->time_ot_early_at && $startAt >= $this->config->time_afternoon_go_late_at) {
                                        $type += WorkTime::TYPES['lately'];
                                    }
                                }
                                if ($endAt) {
                                    if ($endAt <= $this->config->afternoon_end_work_at) {
                                        $type += WorkTime::TYPES['early'];
                                    } else if ($endAt >= $this->config->time_ot_early_at) {
                                        $type += WorkTime::TYPES['ot'];
                                    }
                                }
                            } else {
                                if ($startAt) {
                                    if ($startAt >= $this->config->time_afternoon_go_late_at) {
                                        $type += WorkTime::TYPES['lately'];
                                    } else if ($startAt >= $this->config->time_morning_go_late_at) {
                                        $type += WorkTime::TYPES['lately'];
                                    }
                                }
                                if ($endAt) {
                                    if ($endAt <= $this->config->morning_end_work_at) {
                                        $type += WorkTime::TYPES['early'];
                                    } else if ($endAt <= $this->config->afternoon_end_work_at) {
                                        $type += WorkTime::TYPES['early'];
                                    } else if ($endAt >= $this->config->time_ot_early_at) {
                                        $type += WorkTime::TYPES['ot'];
                                    }
                                }
                            }

                        }
                    }
                }
            }
        } else {
            if ($startAt != null || $endAt != null) {
                $addData = true;
                $type += WorkTime::TYPES['ot'];
            }
        }
        if ($addData)
            return [
                'start_at' => $startAt,
                'end_at' => $endAt,
                'note' => WorkTime::WORK_TIME_CALENDAR_DISPLAY[$type] ?? '',
                'type' => $type,
            ];
    }

    protected function getSearchModel(Request $request, $forExport = false)
    {
        $model = $this->model;
        $year = $request->get('year');

        if ($year) {
            $model = $model->whereYear('work_day', $year);
        }
        $month = $request->get('month');
        if ($month) {
            $model = $model->whereMonth('work_day', $month);
        }
        $work_day = $request->get('work_day');
        if ($work_day) {
            $model = $model->whereDate('work_day', $work_day);
        }
        $type = $request->get('type');
        if ($type != null) {
            if ($type == WorkTime::TYPES['lately']) {
                //lately || lately + early || lately + OT
                $model = $model->whereIn('type', [1, 3, 5]);
            } else if ($type == WorkTime::TYPES['ot']) {
                //OT || lately + OT
                $model = $model->whereIn('type', [4, 5]);
            } else {
                $model = $model->where('type', $type);
            }
        }
        if (!$request->search) {
            $userId = $request->get('user_id');
            if ($userId) {
                $model = $model->where('user_id', $userId);
            }
        }

        if ($forExport) {
            $model->orderBy('user_id')->orderBy('work_day');
        } else if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('work_day', 'desc')->orderBy('user_id');
        }

        return $model;
    }

}
