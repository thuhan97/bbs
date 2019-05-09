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
use App\Repositories\Contracts\IRecurRepository;
use Carbon;
use Illuminate\Support\Facades\Validator;
/**
 * 
 */
class BookingController extends Controller
{
	use RESTActions;

	protected $bookingService;
	protected $recurRepository;
	
	public function __construct(IBookingService $bookingService,IRecurRepository $recurRepository)
	{	
		$this->bookingService= $bookingService;
		$this->recurRepository=$recurRepository;
	}

	public function calendar(){
		$users=User::all();
		$meetings=Meeting::all();
		return view('end_user.booking.calendar',compact('meetings','users'));
	}

	public function getCalendar(Request $request){
		$start= $request->start;
		$end= $request->end;
		$results1=$this->bookingService->getBookings($start,$end);

		$results2=$this->bookingService->getBookingRecurs($start,$end);
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
			$meetings_id=$request->meetings_id;
            $start_time=$request->start_time;
            $end_time=$request->end_time;
            $days_repeat=$request->days_repeat;    
            $check=$this->check($days_repeat,$meetings_id,$start_time,$end_time);
            if($check==NO_DUPLICATE){
            	$date=$request->days_repeat;
            	$data=[
		            	'users_id'=>\Auth::user()->id,
		            	'title'=>$request->title,
			            'content'=>$request->content,
			            'participants'=>$request->participants,
			            'meetings_id'=>$request->meetings_id,
			            'start_time'=>$request->start_time,
			            'end_time'=>$request->end_time,
			            'date'=>$date,
			            'color'=>$request->color,
			            'is_notify'=>$request->is_notify,
			        ]; 
            	if($request->repeat_type==NO_REPEAT){
			        Booking::insert($data);
            	}else{
            		if($request->repeat_type==YEARLY) {
	           			$days_repeat=date('m-d',strtotime($request->days_repeat));
	           		}
		            else if($request->repeat_type==MONTHLY) {
		            		$days_repeat=(new \Carbon($request->days_repeat))->day;
		            	}
		            else if($request->repeat_type==WEEKLY) {
		            	$days_repeat=(new \Carbon($request->days_repeat))->dayOfWeek;
		            }
		            Booking::insert($data);
		            $data['repeat_type']=$request->repeat_type;
		            $data['days_repeat']=$days_repeat;
		            Recur::insert($data) ;
            	}
	            return response()->json(["success"=>true]);
            }
            else return  response()->json(["duplicate"=>true,'status'=>500],200);     
        }   
        
    }

    public function update(Request $request,$id){
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
        	$id=$request->id;
			$meetings_id=$request->meetings_id;
            $start_time=$request->start_time;
            $end_time=$request->end_time;
            $days_repeat=$request->days_repeat;    
            $check=$this->check($days_repeat,$meetings_id,$start_time,$end_time,$id);
            if($check==NO_DUPLICATE){
            	$date=$request->days_repeat;
            	$data=[
		            	'users_id'=>\Auth::user()->id,
		            	'title'=>$request->title,
			            'content'=>$request->content,
			            'participants'=>$request->participants,
			            'meetings_id'=>$request->meetings_id,
			            'start_time'=>$request->start_time,
			            'end_time'=>$request->end_time,
			            'date'=>$date,
			            'color'=>$request->color,
			            'is_notify'=>$request->is_notify,
			        ]; 
            	if($request->repeat_type==NO_REPEAT){
            		
			        $booking=Booking::where('id',$id)->update($data);
		           	
            	}else{
            		if($request->repeat_type==YEARLY) {
	           			$days_repeat=date('m-d',strtotime($request->days_repeat));
	           		}
		            else if($request->repeat_type==MONTHLY) {
		            		$days_repeat=(new \Carbon($request->days_repeat))->day;
		            	}
		            else if($request->repeat_type==WEEKLY) {
		            	$days_repeat=(new \Carbon($request->days_repeat))->dayOfWeek;
		            }
		            $data['repeat_type']=$request->repeat_type;
		            $data['days_repeat']=$days_repeat;
		           	$booking=Recur::where('id',$id)->update($data);
            	}
	            return response()->json(["success"=>true]);
            }
            else return  response()->json(["duplicate"=>true,'status'=>500],200);     
        }   
    }

    public function getBooking(Request $request){
    	$id=$request->id;
    	$meetings_id=$request->meetings_id;
    	$start_time=$request->start_time;
    	$end_time=$request->end_time;
    	$date=$request->date;
    	$condition1=[
    		'id'=>$id,
    		'meetings_id'=>$meetings_id,
    		'start_time'=>$start_time,
    		'end_time'=>$end_time,
    		'date'=>$date
    	];
    	$condition2=[
    		'id'=>$id,
    		'meetings_id'=>$meetings_id,
    		'start_time'=>$start_time,
    		'end_time'=>$end_time,
    	];
    	$booking=(count(Booking::where($condition1)->get())>0)?(Booking::where($condition1)->first()):(Recur::where($condition2)->first());
    	$participants=explode(",",$booking->participants);
    		$objects=[];
    		foreach($participants as $user_id) {
    			$objects[]=(User::find($user_id))->name;
    		}
    		$meeting=Meeting::find($meetings_id)->name;
    	 return response()->json(["booking"=>$booking,"participants"=>$objects,"meeting"=>$meeting]);
    }

    public function deleteBooking(Request $request){
    		$id=$request->id;
	    	$meetings_id=$request->meetings_id;
	    	$start_time=$request->start_time;
	    	$end_time=$request->end_time;
	    	$date=$request->date;
	    	$condition1=[
	    		'id'=>$id,
	    		'meetings_id'=>$meetings_id,
	    		'start_time'=>$start_time,
	    		'end_time'=>$end_time,
	    		'date'=>$date
	    	];
	    	$condition2=[
	    		'id'=>$id,
	    		'meetings_id'=>$meetings_id,
	    		'start_time'=>$start_time,
	    		'end_time'=>$end_time,
	    	];
	    	$booking=(count(Booking::where($condition1)->get())>0)?(Booking::where($condition1)->first()):(Recur::where($condition2)->first());
    	$booking->delete();
    	 return response()->json(["messages"=>"success"]);
    }

    public function check($days_repeat,$meetings_id,$start_time,$end_time,$id=null){
		$date=$days_repeat;
        $date_month=date('m-d',strtotime($days_repeat));
        $day=(new \Carbon($days_repeat))->day;
        $dayOfWeek=(new \Carbon($days_repeat))->dayOfWeek;
		           
    	$check=NO_DUPLICATE;
    	
    	$recur_default=[['id','<>',$id],['meetings_id',$meetings_id]];
    	
    	 // check theo lich khong lap
    	$recur=[];
    	$model=new Booking();
        $recur[0]= $model->where('date',$date)->where($recur_default);
        $model=Recur::where($recur_default);
    	 // check lich tuan
		$recur[1]= clone $model->where('repeat_type',WEEKLY)->where('days_repeat',$dayOfWeek);
		
        //check lich theo thang
		$recur[2]= clone $model->where('repeat_type',MONTHLY)->where('days_repeat',$day);
		
		//check lich theo nam
		$recur[3]= clone $model->where('repeat_type',YEARLY)->where('days_repeat',$date_month);
		
		for($i=0;$i<4;$i++){
			$recurs=$recur[$i];
			if(count($recurs->get())>0) {
				$recurs=$recurs->where(function($q) use($start_time,$end_time){
					$q->where('start_time','>=',$end_time)->orWhere('end_time','<=',$start_time);
				})->get();
				if(count($recurs)>0) $check=NO_DUPLICATE;
				else {
					$check=DUPLICATE;
					return $check;
				}
			}
			else $check=NO_DUPLICATE;
		}
		return $check;
    }
}