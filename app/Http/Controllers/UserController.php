<?php

namespace App\Http\Controllers;
use Auth;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\User;

class UserController extends Controller
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
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

    public function workTime()
    {
        return view('end_user.user.work_time');
    }

    public function dayOff()
    {
        return view('end_user.user.day_off');
    }

    public function contact(Request $request)
    {
        $users = $this->userService->getContact($request, $perPage, $search);

        return view('end_user.user.contact', compact('users', 'search', 'perPage'));
    }

}
