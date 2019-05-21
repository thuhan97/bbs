<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApprovePermissionExport;
use App\Models\WorkTimesExplanation;
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

    public function exportData(Request $request, $search = null)
    {
        switch ($request->path()) {
            case 'admin/approve_permission':
                $approvePermissions = $this->getResourceModel()::search($request['search'])->get();
                return Excel::download(new ApprovePermissionExport($approvePermissions), "approve-permission.xlsx");
                break;
            default:
                abort(404);
        }
    }
}
