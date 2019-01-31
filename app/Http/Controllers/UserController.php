<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
use App\Models\DayOff;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\type;

class UserController extends Controller
{
    private $userService;
    private $userDayOff;

    public function __construct(IUserService $userService, IDayOffService $userDayOff)
    {
        $this->userService = $userService;
        $this->userDayOff = $userDayOff;
    }

    public function index()
    {
        return view('end_user.user.index');
    }

    public function profile()
    {
        return view('end_user.user.profile');
    }

    public function changePassword()
    {
        return view('end_user.user.change_password');
    }

    public function workTime()
    {
        return view('end_user.user.work_time');
    }

    public function dayOff(DayOffRequest $request)
    {
        $conditions = ['user_id' => Auth::id()];
        $listDate = $this->userDayOff->findList($request, $conditions);

        $paginateData = $listDate->toArray();
        $recordPerPage = $request->get('per_page');
        $approve = $request->get('approve');

        $availableDayLeft = $this->userDayOff->getDayOffUser(Auth::id());
        return view('end_user.user.day_off', compact('listDate', 'paginateData', 'availableDayLeft', 'recordPerPage', 'approve'));
    }

    public function dayOffApprove(DayOffRequest $request)
    {
        // Checking authorize for action
        $isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;

        // If user is able to do approve then
	    $searchView = $request->get('search') ?? '';
	    $approval_view = $request->get('approve') == null ? null : (int) $request->get('approve');
	    $atPage_view = $request->get('page') == null ? null : (int) $request->get('page');
	    $perPage_view = $request->get('per_page') == null ? null : (int) $request->get('per_page');

	    $request_view = $this->userDayOff->findList($request, [], ['*'], $searchView, $perPage);
	    $request_view_array = $request_view->toArray();

	    $request->merge(['year' => date('Y')]);
	    $request->merge(['approve'=> null]);
	    $request->merge(['search'=> '']);
	    $search = '';
	    // get all request
	    $totalRequest = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();
	    // get only approved request
	    $request->merge(['approve'=> 1]);
	    $approvedRequest = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();

        return view('end_user.user.day_off_approval', compact(
        	'isApproval', 'totalRequest', 'approvedRequest', 'approval_view', 'atPage_view', 'perPage_view',
	        'request_view', 'request_view_array', 'searchView'
        ));
    }

    public function dayOffApprove_AcceptAPI(Request $request){
	    // Checking authorize for action
//	    $isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;
//
//	    if (!$isApproval || !$request->ajax())
//	    	return response([
//	    		'success' => false
//		    ]);
	    $arrRequest = $request->all();
	    $recievingObject = json_decode(json_encode($arrRequest));

	    $targetRecordResponse = $this->userDayOff->updateStatusDayOff($recievingObject->id, Auth::id(), 'test');

	    return $targetRecordResponse;
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);
        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
