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
		$results1=$this->bookingService->getBooking($start,$end);
		$results2=$this->bookingService->getBookingRecur($start,$end);
		// dd($results2);
		$results=array_merge($results1,$results2);

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
        	//
        			$meetings_id=$request->meetings_id;
		            $start_time=$request->start_time;
		            $end_time=$request->end_time;
		            $days_repeat=$request->days_repeat;
		            $date=$days_repeat;
		            $date_month=date('m-d',strtotime($days_repeat));
		            $day=(new \Carbon($days_repeat))->day;
		            $dayOfWeek=(new \Carbon($days_repeat))->dayOfWeek;


		

		            $recur=Recur::where('repeat_type',0)->where('days_repeat',$date)->where('meetings_id',$meetings_id);;
					if(count($recur->get())>0) {
						$recur=$recur->where('start_time','>=',$end_time)->orWhere('end_time','<=',$start_time)->get();
						if(count($recur)==0) dd('khong');
						else dd('trung');
					}
					else dd(1);

		            // $recur=Recur::where('meetings_id',$meetings_id)->where('start_time','<=',$start_time)->where('end_time','>=',$start_time)->where('start_time','<=',$end_time)->where('end_time','>=',$end_time);
		            // if(count($recur->get())>0){
		            // 	$recur=$recur->where('days_repeat',$date)->orWhere('days_repeat',$date_month)->orWhere('days_repeat',$day)->orWhere('days_repeat',$dayOfWeek);
		            // 	if(count($recur->get())>0){
		            // 		// return response()->json(["duplicate"=>'Vui lòng chọn phòng họp khác vì đã trùng.','status'=>422],200);
		            // 		dd('trùng');
		            // 	}
		            // 	else dd('không trùng');
		            // }
		            // else{
		            // 	dd('không trùng');
		            // }

				// $recur="Select * from recurs where ('repeat_type'=0 AND 'meetings_id'=".$meetings_id .") AND  ('start_time'<=".$start_time."")
    //     	//
           		$date=$request->days_repeat;
	           	if($request->repeat_type==YEARLY) {
	           		$days_repeat=date('m-d',strtotime($request->days_repeat));
	           	}
	            else if($request->repeat_type==MONTHLY) {
	            		$days_repeat=(new \Carbon($request->days_repeat))->day;
	            	}
	            else if($request->repeat_type==WEEKLY) {
	            	$days_repeat=(new \Carbon($request->days_repeat))->dayOfWeek;
	            }
	            else {
	            	
	            	$days_repeat=$request->days_repeat;
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

    public function getBooking(Request $request,$id){
    	$start_date=$request->start_date;
    	if($start_date>\Carbon::now()){
    		$booking = Recur::findOrFail($id);
    		$participants=explode(",",$booking->participants);
    		$objects=[];
    		foreach($participants as $user_id) {
    			$objects[]=(User::findOrFail($user_id))->name;
    		}
    		$meeting=Meeting::findOrFail($booking->meetings_id)->name;
    		$type=FUTURE;
    		
    	}
    	else{
    		$booking = Booking::findOrFail($id);
    		$participants=explode(",",$booking->participants);
    		$objects=[];
    		foreach($participants as $user_id) {
    			$objects[]=(User::findOrFail($user_id))->name;
    		}
    		$meeting=Meeting::findOrFail($booking->meetings_id)->name;
    		$type=PAST;
    	}
    	 return response()->json(["booking"=>$booking,"participants"=>$objects,"meeting"=>$meeting,"type"=>$type]);
    }

    public function deleteBooking(Request $request, $id){
    		$booking = Recur::where('id',$id)->delete();		
    	 return response()->json(["messages"=>"success"]);
    }
}