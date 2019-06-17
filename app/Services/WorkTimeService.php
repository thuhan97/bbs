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
use App\Models\User;
use App\Models\WorkTime;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Services\Contracts\IWorkTimeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * @property Config config
 */
class WorkTimeService extends AbstractService implements IWorkTimeService
{
    const LATE_UNIT = 1000;
    const LATE_SECOND_SUFFIX = ':00'; //00 to 59

    private $calendarOffs;
    /**
     * @var PunishesService
     */
    private $punishesService;

    /**
     * WorkTimeService constructor.
     *
     * @param \App\Models\WorkTime                            $model
     * @param \App\Repositories\Contracts\IWorkTimeRepository $repository
     * @param PunishesService                                 $punishesService
     */
    public function __construct(WorkTime $model, IWorkTimeRepository $repository, PunishesService $punishesService)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->config = Config::first();
        $this->calendarOffs = CalendarOff::all();
        $this->additionalDates = AdditionalDate::all();

        $this->users = User::select('id', 'name', 'staff_code', 'contract_type', 'is_remote', 'jobtitle_id')
            ->with('workTimeRegisters')
            ->get();

        $this->punishesService = $punishesService;
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

    public function deletes($startDate, $endDate, $isAllUser, $userIds)
    {
        $model = WorkTime::whereDate('work_day', '>=', $startDate)
            ->whereDate('work_day', '<=', $endDate);

        if (!$isAllUser) {
            $model = $model->whereIn('id', $userIds);
        }

        $model->delete();
    }

    public function importWorkTime($userCode, $staffCode, $work_day, $startAt, $endAt)
    {
        $userId = $userCode[$staffCode];
        $user = $this->users->firstWhere('id', $userId);

        if ($user) {
            $workTime = $this->getWorkTime($user, $work_day, $startAt, $endAt);

            if ($workTime) {
                $workTime['user_id'] = $userId;
                $workTime['work_day'] = $work_day->format(DATE_FORMAT_SLASH);
            }
            return $workTime;
        }
    }

    /**
     * @param $user
     * @param $date
     * @param $startAt
     * @param $endAt
     *
     * @return array
     * @throws \Exception
     */
    public function getWorkTime($user, $date, $startAt, $endAt)
    {
        if ($endAt == null && $startAt != null && $startAt > HAFT_AFTERNOON) {
            [$startAt, $endAt] = [$endAt, $startAt];
        }
        if (!$this->config->time_afternoon_go_late_at) throw new \Exception(__l('system_no_config_time'));
        $addData = false;
        $type = 0;
        $cost = 0;
        $checkIsAdditionalDate = $this->additionalDates->firstWhere('date_add', $date->format(DATE_FORMAT));
        //
        $check = !$checkIsAdditionalDate && $this->calendarOffs->where('date_off_from', '>=', $date->format(DATE_FORMAT))->where('date_off_to', '<=', $date->format(DATE_FORMAT))->first();
        $notes = [];
        if ($check) {
            $type = WorkTime::TYPES['calendar_off'];
            return [
                'start_at' => null,
                'end_at' => null,
                'note' => WorkTime::WORK_TIME_CALENDAR_DISPLAY[$type] ?? '',
                'type' => $type,
                'cost' => WORKTIME_COST_OFF,
            ];
        } else if (($this->config->work_days && in_array($date->format('N'), $this->config->work_days)) || !$this->config->work_days || $checkIsAdditionalDate) {
            //checkin in week
            //getworktime of user
            if (!$user->is_remote && in_array($user->contract_type, [CONTRACT_TYPES['staff'], CONTRACT_TYPES['probation']])) {
                $addData = true;
                //check day is off
                if ($startAt == null && $endAt == null) {
                    $type = WorkTime::TYPES['off'];
                    $notes[] = __('worktimes.no_info');

                } else {
                    list($cost, $type, $notes) = $this->getCostWorkTime(null, $startAt, $endAt);
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
                            $notes[] = __('worktimes.no_info');
                        } else {
                            if ($workTime->end_at <= SWITCH_TIME) {
                                list($cost, $type, $notes) = $this->getCostWorkTime($workTime->start_at, $startAt, $endAt, -1);
                            } else if ($workTime->start_at >= SWITCH_TIME) { //afternoon only
                                list($cost, $type, $notes) = $this->getCostWorkTime($workTime->start_at, $startAt, $endAt, 1);
                            } else {
                                list($cost, $type, $notes) = $this->getCostWorkTime($workTime->start_at, $startAt, $endAt);
                            }
                        }
                    }
                }
            }
        } else {
            if ($startAt != null || $endAt != null) {
                $addData = true;
                $notes[] = __('worktimes.ot_weekend');

                $type += WorkTime::TYPES['ot'];
            }
        }
        if ($addData)
            return [
                'start_at' => $startAt,
                'end_at' => $endAt,
                'note' => implode(', ', $notes),
                'type' => $type,
                'cost' => $cost,
            ];
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
        $date = date_create($fromDate);
        $month = $date->format('m');

        $this->punishesService->calculateLateTime($date->format('Y'), $month, $userIds);
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
        $userId = $request->get('user_id');
        if ($userId) {
            $model = $model->where('user_id', $userId);
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

    /**
     * @param     $user
     * @param     $startAt
     * @param     $endAt
     * @param int $typeCheck : 0: full, -1: morning; 1: afternoon
     *
     * @return array
     */
    private function getCostWorkTime($registerAt, $startAt, $endAt, $typeCheck = 0)
    {
        $type = 0;
        $notes = [];
        if ($registerAt) {
            $registerAt = date_create($registerAt)->modify('+1 minutes')->format('H:i:s');
        }
        if ($startAt) {
            $startAt .= ':00';
            //check đi muộn quá nửa buổi chiều -> nghỉ ngày
            if ($typeCheck >= 0 && $startAt >= HAFT_HOUR) {
                $timeLateAt = $registerAt ?? $this->config->time_afternoon_go_late_at;
                if ($startAt >= HAFT_AFTERNOON) {
                    $type = WorkTime::TYPES['off'];
                    $notes[] = __('worktimes.off');
                    $notes[] = __('worktimes.late_over_haft_afternoon');
                } //check đi muộn buổi chiều
                else if ($startAt >= $timeLateAt) {
                    $type += WorkTime::TYPES['lately'];
                    $notes[] = __('worktimes.lately_afternoon');
                } //Chấm công buổi chiều, nghỉ sáng
                elseif ($typeCheck == 0)
                    $notes[] = __('worktimes.off_morning');
            }
            if ($typeCheck <= 0 && $startAt < HAFT_HOUR) {
                $timeLateAt = $registerAt ?? $this->config->time_morning_go_late_at;

                //check đi muộn quá nửa buổi sáng -> nghỉ sáng
                if ($startAt >= HAFT_MORNING) {
                    $notes[] = __('worktimes.late_over_haft_morning');
                } else if ($startAt >= $timeLateAt) {
                    $type += WorkTime::TYPES['lately'];
                    $notes[] = __('worktimes.lately_morning');
                }
            }
        }
        if ($endAt && $type != WorkTime::TYPES['off']) {
            $endAt .= ':00';

            if ($typeCheck >= 0) {
                if ($startAt > HAFT_HOUR && $endAt < HAFT_AFTERNOON) {
                    $notes[] = __('worktimes.early_over_haft_afternoon');
                    if ($typeCheck > 0) {
                        $type = WorkTime::TYPES['off'];
                    }
                } else
                    if ($endAt < $this->config->afternoon_end_work_at) {

                        $type += WorkTime::TYPES['early'];
                        $notes[] = __('worktimes.early_afternoon');
                    }
            }
            if ($typeCheck <= 0) {
                if ($endAt < $this->config->morning_end_work_at) {
                    $type += WorkTime::TYPES['early'];
                    $notes[] = __('worktimes.early_morning');

                } else if ($endAt < HAFT_MORNING) {
                    $notes[] = __('worktimes.early_over_haft_morning');
                    if ($typeCheck < 0) {
                        $type = WorkTime::TYPES['off'];
                    }
                }
            }

            if ($this->config->time_ot_early_at && $endAt >= $this->config->time_ot_early_at) {
                $type += WorkTime::TYPES['ot'];
                $notes[] = __('worktimes.ot');
            }

        }
//cost
        $cost = 0;
        $costStartAt = $startAt ?? $this->config->morning_start_work_at;
        $costEndAt = $endAt ?? $this->config->afternoon_end_work_at;

        if ($typeCheck == 0) {
            if ($costStartAt <= HAFT_MORNING && $costEndAt >= HAFT_AFTERNOON) {
                $cost = 1;
            } else if (//morning
                ($costStartAt <= HAFT_MORNING && $costEndAt < HAFT_AFTERNOON)
                //afternoon
                || ($costStartAt > HAFT_MORNING && $costEndAt >= HAFT_AFTERNOON)) {
                $cost = 0.5;
            }
        } else if ($typeCheck > 0 && $costStartAt < HAFT_AFTERNOON && $costEndAt >= HAFT_AFTERNOON) {
            $cost = 0.5;
        } else if ($typeCheck < 0 && $costStartAt <= HAFT_MORNING && $costEndAt > HAFT_MORNING) {
            $cost = 0.5;
        }

        return [$cost, $type, $notes];
    }

}
