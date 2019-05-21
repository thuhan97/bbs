<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OTListExport;
use App\Models\OverTime;
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
    protected $resourceModel = OverTime::class;

    protected $meetingService;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Duyệt OT';

    public function exportData(Request $request, $search = null)
    {
        switch ($request->path()) {
            case 'admin/over_times':
                $overTimes = $this->getResourceModel()::search($request['search'])->get();
                return Excel::download(new OTListExport ($overTimes), "over-time.xlsx");
                break;
            default:
                abort(404);
        }
    }

}
