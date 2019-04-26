<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OTListExport;
use App\Models\OverTime;
use App\Repositories\Contracts\IOverTimeRepository;
use App\Services\Contracts\IOverTimeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OverTimeController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.over_times';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::over_times';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = OverTime::class;

    protected $meetingService;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Duyệt OT';

    public function __construct(IOverTimeRepository $repository, IOverTimeService $overTimeService)
    {
        $this->repository = $repository;
        $this->overTimeService = $overTimeService;
        parent::__construct();
    }


    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());
        if ($request->has('is_export') && in_array($request->path(), OVER_TIME_EXPORT_PATHS)) {
            return $this->exportData($request);
        } else {
            $records = $this->searchRecords($request, $perPage, $search);
            return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
                'records' => $records,
                'search' => $search,
                'resourceAlias' => $this->getResourceAlias(),
                'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
                'resourceTitle' => $this->getResourceTitle(),
                'perPage' => $perPage,
                'resourceSearchExtend' => $this->resourceSearchExtend,
                'addVarsForView' => $this->addVarsSearchViewData()
            ]));
        }
    }

    public function getSearchRecords(Request $request, $perPage = 50, $search = null, $paginatorData = [])
    {
        $query = $this->getSearchModel($request, $paginatorData);

        return $query->paginate($perPage)->appends($paginatorData);
    }

    public function getSearchModel(Request $request, &$paginatorData = [])
    {
        return $this->overTimeService->getListOverTime($request, array_search('Overtime', WORK_TIME_TYPE));
    }

    public function exportData(Request $request)
    {
        switch ($request->path()) {
            case OVER_TIME_EXPORT_PATHS[0]:
                $explanations = $this->overTimeService->getListOverTime($request, array_search('Overtime', WORK_TIME_TYPE));
                return Excel::download(new OTListExport($explanations), "over-time.xlsx");
                break;

            default:
                abort(404);
        }
    }

}
