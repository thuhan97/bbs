<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Recur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\RESTActions;
use Carbon;
/**
 * 
 */
class BookingController extends Controller
{
	use RESTActions;
	
	public function __construct()
	{	
	}

	public function calendar(){
		
		return view('end_user.booking.calendar');
	}

	public function getCalendar(Request $request){
		$results=[];
		$bookings=Booking::all();
		if ($bookings->isNotEmpty()) {
            foreach ($bookings as $booking) {
                $results[] = [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'description' => $booking->content,
                    'start' => $booking->start_date,
                    'end' => $booking->end_date,
                    'textColor'=>'#fff',
                    'color'=>$booking->color,
                ];
            }
        }
		
		$firstDayOfWeek=$request->start;
		$lastDayOfWeek=$request->end;
		if(date('Y-m-d',strtotime($firstDayOfWeek))>\Carbon::now()->format('Y-m-d')){
			$recurs=Recur::all();
			foreach($recurs as $recur){
				$startDate=null;
				if($recur->repeat_type==1){
					$startDate=date('Y-m-d', strtotime( $request->start.' + '.$recur->days_repeat.' days'));
					// dd($startDate);
				}
				elseif($recur->repeat_type==2){
					 	$day= self::getDateOfRecurMonthly($firstDayOfWeek,$lastDayOfWeek, $recur->days_repeat);
					 	if($day!=null){
					 		$startDate=$day;
					 	}
				}
				else{
					$day=self::getDateOfRecurYearly($firstDayOfWeek,$lastDayOfWeek, $recur->days_repeat);
					if($day!==null)
						$startDate=$day;

				}
				if($startDate!=null){
					$results[]=[
						
	                    'title' => $recur->title,
	                    'description' => $recur->content,
	                    'start' => $startDate.' '. $recur->start_time,
	                    'end' => $startDate.' '.$recur->end_time,
	                    'textColor'=>'#fff',
	                    'color'=>$recur->color,
					];
					// dd($results);
				}
			}
		}
		
        // dd($results);

        return $this->respond(['bookings' => $results]);
	}

	public function getDateOfRecurMonthly($startDate, $endDate, $currentDate){

		$startDay=date('d',strtotime($startDate));
		$startMonth=date('m',strtotime($startDate));
		$startYear=date('Y',strtotime($startDate));
		// dd($startYear);
		$endDay=date('d',strtotime($endDate));
		$endMonth=date('m',strtotime($endDate));
		$endYear=date('Y',strtotime($endDate));
		if($startYear==$endYear){
			if($startMonth==$endMonth){
				if($startDay<=$currentDate && $endDay>=$currentDate){
					$date=$startYear.'-'.$startMonth.'-'.$currentDate;
					return $date;
				}	
				return null;	
			}
			else {
				// dd($endMonth);
				if($startDay<=$currentDate){
					return $startYear.'-'.$startMonth.'-'.$currentDate;
				}
				else if($endtDay>=$currentDate){
					return $startYear.'-'.$endMonth.'-'.$currentDate;
				}
				else return null;
			}
		}
		else{
			if($startDay<=$currentDate){
				return $startYear.'-'.$startMonth.'-'.$currentDate;
			}
			else if($endtDay>=$currentDate){
				return $endYear.'-'.$endMonth.'-'.$currentDate;
			}
			else return null;
		}
	}

	public function getDateOfRecurYearly($startDate, $endDate, $currentDate){
		$firstDayOfWeek= date('Y-m-d',strtotime($startDate));
		$lastDayOfWeek= date('Y-m-d',strtotime($endDate));

		$startDay=date('d',strtotime($startDate));
		$startMonth=date('m',strtotime($startDate));
		$startYear=date('Y',strtotime($startDate));
		$endDay=date('d',strtotime($endDate));
		$endMonth=date('m',strtotime($endDate));
		$endYear=date('Y',strtotime($endDate));
		$currentDay=date('d',strtotime($currentDate));
		$currentMonth=date('m',strtotime($currentDate));
		if($startYear==$endYear){
			$date=date('Y-m-d',strtotime($startYear.'-'.$currentDate));
			if($firstDayOfWeek<=$date && $date<=$lastDayOfWeek){
				return $date;
			}
			return null;
		}
		else{
			if($currentMonth==12){
				$date=date('Y-m-d',strtotime($startYear.'-'.$currentDate));
				if($firstDayOfWeek<=$date && $date<=$lastDayOfWeek){
					return $date;
				}
			}
			else if ($currentMonth==1) {
				$date=date('Y-m-d',strtotime($endYear.'-'.$currentDate));
				if($firstDayOfWeek<=$date && $date<=$lastDayOfWeek){
					return $date;
				}
			}
			else return null;
		}
	}
}