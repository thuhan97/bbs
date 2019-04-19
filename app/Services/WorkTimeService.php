<?php
/**
 * WorkTimeService class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Services;

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
        $model = $this->model;
        $year = $request->get('year');

        if ($year) {
            $model = $model->whereYear('work_day', $year);
        }
        $month = $request->get('month');
        if ($month) {
            $model = $model->whereMonth('work_day', $month);
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

        return $model->orderBy('work_day', 'desc')->search($search)->paginate($perPage);
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
     * @param $startAt
     * @param $endAt
     *
     * @return array
     */
    private function getWorkTime($user, $date, $startAt, $endAt)
    {
        if (!$this->config->time_afternoon_go_late_at) throw new \Exception('Chưa cấu hình thời gian thiết lập hệ thống.');
        $addData = false;
        $type = 0;
        //checkin in week
        if (($this->config->work_days && in_array($date->format('N'), $this->config->work_days)) || !$this->config->work_days) {
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


}
