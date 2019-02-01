<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
use App\Transformers\DayOffTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
		$user = Auth::user();
		return view('end_user.user.profile', compact('user'));
	}

    public function saveProfile(ProfileRequest $request)
    {
        $data = $request->only('address', 'current_address', 'gmail', 'gitlab', 'chatwork', 'skills', 'in_future', 'hobby', 'foreign_laguage', 'school');

        if ($request->hasFile('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = $avatar->getClientOriginalName();
            $destinationPath = public_path(URL_IMAGE_AVATAR);
            $data['avatar'] = URL_IMAGE_AVATAR . $avatarName;
            $avatar->move($destinationPath, $avatarName);
        }

        $user = User::updateOrCreate([
            'id' => Auth::id(),
        ], $data);

        return redirect(route('profile'))->with('success', 'Thiết lập hồ sơ thành công!');

    }

    public function changePassword()
    {
        return view('end_user.user.change_password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('auth.current_password_incorrect'));
                }
            },],
            'password' => 'required|confirmed|min:6|different:current_password',
        ], [
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ'
        ],
            ['password' => 'mật khẩu mới']
        );

        $user->password = $request->get('password');
        $user->save();
        Auth::logout();

        return redirect('/login');
    }

	public function workTime()
	{
		return view('end_user.user.work_time');
	}



	//
	//
	//  DAY OFF SECTION
	//
	//

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

	public function dayOffCreate_API(DayOffRequest $request)
	{
		$response = [
			'success' => false,
			'message' => NOT_AUTHORIZED
		];
		if (!$request->ajax() || !Auth::check()) {
			return response($response);
		}

		$indicate = $this->userDayOff->create(
			Auth::id(), $request->input('title'),
			$request->input('reason'),
			$request->input('start_at'),
			$request->input('end_at'),
			$request->input('approver_id')
		);


		$response['message'] = !!$indicate['record'] ? "Gửi thành công!" : $indicate['message'];
		$response['success'] = $indicate['status'];
		$response['record'] = $indicate['record'];

		return response($response);
	}

	public function dayOffListApprovalAPI(Request $request)
	{
		$response = [
			'success' => false,
			'message' => NOT_AUTHORIZED
		];
		if (!$request->ajax() || !Auth::check()) {
			return response($response);
		}

		$dataResponse = $this->userDayOff->listApprovals();

		return response([
			'success' => true,
			'message' => "Danh Sách người phê duyệt",
			'data' => $dataResponse->toArray()
		]);
	}

	public function dayOffApprove(DayOffRequest $request)
	{
		// Checking authorize for action
		$isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;

		// If user is able to do approve then
		$searchView = $request->get('search') ?? '';
		$approval_view = $request->get('approve');
		$atPage_view = $request->get('page');
		$perPage_view = $request->get('per_page');

		$request_view = $this->userDayOff->findList($request, ['approver_id' => Auth::id()], ['*'], $searchView, $perPage);
		$request_view_array = $request_view->toArray();

		$request->merge(['year' => date('Y')]);
		$request->merge(['approve' => null]);
		$request->merge(['search' => '']);
		$search = '';
		// get all request
		$totalRequest = $this->userDayOff->findList($request, ['approver_id' => Auth::id()], ['*'], $search, $perPage)->toArray();
		// get only approved request
		$request->merge(['approve' => 1]);
		$approvedRequest = $this->userDayOff->findList($request, ['approver_id' => Auth::id()], ['*'], $search, $perPage)->toArray();

		return view('end_user.user.day_off_approval', compact(
			'isApproval', 'totalRequest', 'approvedRequest', 'approval_view', 'atPage_view', 'perPage_view',
			'request_view', 'request_view_array', 'searchView'
		));
	}

	public function dayOffApprove_get(Request $request, $id)
	{
		if (!$request->ajax() || !Auth::check() || $id === null) {
			return null;
		}

		$responseObject = $this->userDayOff->getRecordOf($id);
		if ($responseObject == null) return null;
		$transformer = new DayOffTransformer();

		return $transformer->transform($responseObject);
	}

	public function dayOffApprove_AcceptAPI(Request $request)
	{
		$response = [
			'success' => false,
			'message' => NOT_AUTHORIZED
		];

//	     Checking authorize for action
		$isApproval = Auth::user()->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE;

		if (!$isApproval || !$request->ajax()) {
			return response($response);
		}

		$arrRequest = $request->all();
		$recievingObject = (object)$arrRequest;
//		return 	$recievingObject;

		$targetRecordResponse = $this->userDayOff->updateStatusDayOff(
			$recievingObject->id, Auth::id(), $recievingObject->approve_comment,
			$recievingObject->number_off
		);

		if ($targetRecordResponse) {
			$response['message'] = 'Cập nhật thành công.';
			$response['success'] = true;
		} else {
			$response['message'] = 'Cập nhật thất bại. Đơn xin không tồn tại hoặc có lỗi xảy ra với server';
			$response['success'] = false;
		}
		return response($response);
	}

	//
	//
	//  CONTACT
	//
	//

	public function contact(Request $request)
	{
		$users = $this->userService->getContact($request, $perPage, $search);
		return view('end_user.user.contact', compact('users', 'search', 'perPage'));
	}

}
