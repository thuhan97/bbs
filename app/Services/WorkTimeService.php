<?php 
/**
* WorkTimeService class
* Author: jvb
* Date: 2019/01/22 10:50
*/

namespace App\Services;

use App\Models\WorkTime;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Services\Contracts\IWorkTimeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
        if ($type) {
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
        return $model->search($search)->paginate($perPage);
    }
}
