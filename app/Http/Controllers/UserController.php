<?php

namespace App\Http\Controllers;

use App\Http\Requests\DayOffRequest;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IUserService;
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
        $user=Auth::user();
        return view('end_user.user.profile',compact('user'));
    }
    public function saveProfile(ProfileRequest $request){
        
            $data = $request->only('address','current_address','gmail','gitlab','chatwork','skills','in_future','hobby','foreign_laguage');
            if ($request->hasFile('avatar')) {
                $avatar = request()->file('avatar');
                $avatarName = $avatar->getClientOriginalName();
                $destinationPath = public_path('/uploads/');
                $data['avatar']=$avatarName;
                $avatar->move($destinationPath, $avatarName);    
            }
            
            $user = User::updateOrCreate([
                'id' => Auth::id(),
            ], $data); 
            
            return redirect(route('profile'))->with('success','Thiết lập hồ sơ thành công!'); 
      
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
        $request->merge(['year' => date('Y')]);
        $search = $criterias['search'] ?? '';
        $totalRecord = $this->userDayOff->findList($request, [], ['*'], $search, $perPage)->toArray();

        return view('end_user.user.day_off_approval', compact('isApproval', 'totalRecord'));
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);
        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
