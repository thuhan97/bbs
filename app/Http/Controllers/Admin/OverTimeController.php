<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OTListExport;
use App\Models\WorkTimesExplanation;
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
    protected $resourceModel = WorkTimesExplanation::class;

    protected $meetingService;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Duyệt OT';

    public function getSearchRecords(Request $request, $perPage = 50, $search = null, $paginatorData = [])
    {
        $model = $this->getResourceModel()::search($search)->where('type', array_search('Overtime', WORK_TIME_TYPE));
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
            case 'admin/over_times':
                $overTimes = $this->getResourceModel()::search($request['search'])->where('type', array_search('Overtime', WORK_TIME_TYPE))->get();
                return Excel::download(new OTListExport($overTimes), "over-time.xlsx");
                break;
            default:
                abort(404);
        }
    }

}
