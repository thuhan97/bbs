<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApprovePermissionExport;
use App\Models\WorkTimesExplanation;
use App\Repositories\Contracts\IOverTimeRepository;
use App\Services\Contracts\IOverTimeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ApprovePermissionController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.approve_permission';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::approve_permission';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = WorkTimesExplanation::class;

    protected $meetingService;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Xin phép';

    public function getSearchRecords(Request $request, $perPage = 50, $search = null, $paginatorData = [])
    {
        $model = $this->getResourceModel()::search($search);
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('id', 'desc');
        }

        return $model->paginate($perPage);
    }

    public function exportData(Request $request, $search = null)
    {
        switch ($request->path()) {
            case 'admin/approve_permission':
                $explanations = $this->getResourceModel()::search($request['search'])->get();
                return Excel::download(new ApprovePermissionExport($explanations), "over-time.xlsx");
                break;
            default:
                abort(404);
        }
    }

//    public function exportData(Request $request)
//    {
//        switch ($request->path()) {
//            case 'admin/approve_permission':
//                $explanations = $this->overTimeService->getListOverTime($request, 4);
//                return Excel::download(new ApprovePermissionExport($explanations), "over-time.xlsx");
//                break;
//            default:
//                abort(404);
//        }
//    }

//    public function __construct(IOverTimeRepository $repository, IOverTimeService $overTimeService)
//    {
//        $this->repository = $repository;
////        $this->overTimeService = $overTimeService;
//        parent::__construct();
//    }

//    public function getSearchRecords(Request $request, $perPage = 50, $search = null, $paginatorData = [])
//    {
//        $query = $this->getSearchModel($request, $paginatorData);
//
//        return $query->paginate($perPage)->appends($paginatorData);
//    }
//
//    public function getSearchModel(Request $request, &$paginatorData = [])
//    {
//        return $this->overTimeService->getListOverTime($request, array_search('Overtime', WORK_TIME_TYPE));
//    }

//    public function exportData(Request $request)
//    {
//        switch ($request->path()) {
//            case 'admin/over_times':
//                $explanations = $this->overTimeService->getListOverTime($request, array_search('Overtime', WORK_TIME_TYPE));
//                return Excel::download(new OTListExport($explanations), "over-time.xlsx");
//                break;
//
//            default:
//                abort(404);
//        }
//    }

}
