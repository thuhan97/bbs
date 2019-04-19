<?php
/**
 * User: jvb
 * Date: 4/4/2019
 * Time: 3:31 PM
 */

namespace App\Services;

use App\Models\Statistics;
use App\Repositories\Contracts\IStatisticRepository;
use App\Services\Contracts\IStatisticService;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticService extends AbstractService implements IStatisticService
{
    const TYPE_ONE = 1;
    const TYPE_TWO = 2;
    const TYPE_THREE = 3;

    /**
     * StatisticService constructor.
     *
     * @param \App\Models\Statistics $model
     * @param \App\Repositories\Contracts\IStatisticRepository $repository
     */
    public function __construct(Statistics $model, IStatisticRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param integer $perPage
     * @param string $search
     *
     * @return collection
     */
    public function search(Request $request, &$perPage, &$search)
    {
        $model = $this->model;
        // year
        $year = $request->get('year');
        // month
        $month = $request->get('month');
        // week
        $week = $request->get('week');
        // date
        $date = $request->get('date');

        //$type_search = $this->_getConditon($request);

        $search_type = $request->get('statistics') ? $request->get('statistics'): 1;
        if ($search_type == self::TYPE_ONE) {
            if ($date) {
                $date = explode('/', $date);
                $item = implode('-', array_reverse($date, true));
                $model = $model->whereDate('work_day', $item);
            } else {
                $model = $model->whereDate('work_day', date('Y-m-d'));
            }
        } elseif ($search_type == self::TYPE_TWO) {
            if ($week) {
                $explode = explode(' - ', $week);
                foreach ($explode as $index => $item) {
                    $item = explode('/', $item);
                    $item = implode('-', array_reverse($item, true));
                    $explode[$index] = $item;
                }
                if (isset($explode[0])) {
                    $model = $model->whereDate('work_day', '>=', $explode[0]);
                }
                if (isset($explode[1])) {
                    $model = $model->whereDate('work_day', ' <= ', $explode[1]);
                }
            }
            // team
            $team_id = $request->get('team_id');
            if ($team_id) {
                $user_team = DB::table('user_teams')->where('team_id', $team_id)->pluck('user_id', 'id')->toArray();
                if (!empty($user_team)) {
                    $model = $model->whereIn('user_id', $user_team);
                }
            } else {
                $model = $model->where('user_id', '-999');
            }
        } else {
            if ($year) {
                $model = $model->whereYear('work_day', $year);
            }
            if ($month) {
                $model = $model->whereMonth('work_day', $month);
            }
            $user_id = $request->get('user_id');
            if ($user_id) {
                $model = $model->where('user_id', $user_id);
            } else {
                $model = $model->where('user_id', '-999');
            }
            $model = $model->orderBy('work_times.work_day', 'ASC');
            $model = $model->whereNotIn('type', [1, 2]);
        }
        return $model->search($search);
    }

    /**
     * @param Request $request
     * @param $perPage
     * @param $search
     * @return mixed
     */
    public function chart(Request $request, &$perPage, &$search)
    {
        $model = $this->model;
        // year
        $year = $request->get('year');
        if ($year) {
            $model = $model->whereYear('work_day', $year);
        }
        // month
        $month = $request->get('month');
        if ($month) {
            $model = $model->whereMonth('work_day', $month);
        }
        // week
        $week = $request->get('week');
        if ($week) {
            $explode = explode(' - ', $week);
            foreach ($explode as $index => $item) {
                $item = explode('/', $item);
                $item = implode('-', array_reverse($item, true));
                $explode[$index] = $item;
            }
            if (isset($explode[0])) {
                $model = $model->whereDate('work_day', '>=', $explode[0]);
            }
            if (isset($explode[1])) {
                $model = $model->whereDate('work_day', ' <= ', $explode[1]);
            }
        }
        // date
        $date = $request->get('date');
        if ($date) {
            $date = explode('/', $date);
            $item = implode('-', array_reverse($date, true));
            $model = $model->whereDate('work_day', $item);
        }
        $model->selectRaw('count(*) as xx')->groupBy('work_times.type');
        return $model->search($search)->get()->toArray();
    }


    /**
     * @param $request
     * @return int
     */
    private function _getConditon($request)
    {
        // Month
        $month = $request->get('month');
        // Week
        $week = $request->get('week');
        // Date
        $date = $request->get('date');
        if (isset($month) && isset($week) && isset($date)) {
            return 1;
        } elseif (isset($month) && isset($week) && !isset($date)) {
            return 2;
        } elseif (isset($month) && !isset($week) && !isset($date)) {
            return 3;
        } elseif (!isset($month) && isset($week) && isset($date)) {
            return 4;
        } elseif (!isset($month) && !isset($week) && isset($date)) {
            return 5;
        } elseif (!isset($month) && isset($week) && !isset($date)) {
            return 6;
        } else {
            return 7;
        }
    }
}