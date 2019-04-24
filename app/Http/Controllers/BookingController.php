<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Recur;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\RESTActions;
use App\Services\Contracts\IBookingService;
use Carbon;
use Illuminate\Support\Facades\Validator;
/**
 * 
 */
class BookingController extends Controller
{
	use RESTActions;

	protected $bookingService;
	
	public function __construct(IBookingService $bookingService)
	{	
		$this->bookingService= $bookingService;
	}

	public function calendar(){
		$users=User::all();
		$meetings=Meeting::all();
		return view('end_user.booking.calendar',compact('meetings','users'));
	}

	public function getCalendar(Request $request){
		$start= $request->start;
		$end= $request->end;
		$results=$this->bookingService->getBookingRecur($start,$end);

        return $this->respond(['bookings' => $results]);
	}
	public function booking(Request $request){
        $rules=[
            'title'=>'required',
            'content'=>'required',
            'participants'=>'required',
            'meetings_id'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ];
        $messages = [
            'required'  => 'Vui lòng không để trống :attribute .',
        ];
        $attributes=[
            'title'=>'tiêu đề',
            'content'=>'nội dung',
            'participants'=>'đối tượng',
            'meetings_id'=>'phòng họp',
            'start_time'=>'thời gian bắt đầu',
            'end_time'=>'thời gian kết thúc',
        ];
        $validator = Validator::make($request->all(),$rules,$messages,$attributes);
        if ($validator->fails()) { 
           return  response()->json(["errors"=>$validator->errors(),'status'=>422],200);

        }else{
           		$date=null;
	           	if($request->repeat_type==3) $days_repeat=date('m-d',strtotime($request->days_repeat));
	            else if($request->repeat_type==2) $days_repeat=(new \Carbon($request->days_repeat))->day;
	            else if($request->repeat_type==1 ) $days_repeat=(new \Carbon($request->days_repeat))->dayOfWeek;
	            else {
	            	$date=$request->days_repeat;
	            	$days_repeat=null;
	            }
	           	$data=[
	            	'users_id'=>\Auth::user()->id,
	            	'title'=>$request->title,
		            'content'=>$request->content,
		            'participants'=>$request->participants,
		            'meetings_id'=>$request->meetings_id,
		            'start_time'=>$request->start_time,
		            'end_time'=>$request->end_time,
		            'color'=>$request->color,
		            'is_notify'=>$request->is_notify,
		            'repeat_type'=>$request->repeat_type,
		            'days_repeat'=>$days_repeat,
		            'date'=>$date
	            ]; 
	            Recur::insert($data) ;
           

            return response()->json(["success"=>true]);
            
        }   

        
    }
}