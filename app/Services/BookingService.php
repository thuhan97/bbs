<?php
/**
 * EventService class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */

namespace App\Services;

use App\Models\Booking;
use App\Models\Recur;
use App\Services\Contracts\IBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookingService extends AbstractService implements IBookingService
{
    /**
     * BookingService constructor.
     *
     * @param \App\Models\Booking $booking
     * @param \App\Models\Recur $recur
     */
    public function __construct()
    {
        
    }

    

    /**
     * @param int $id
     *
     * @return Booking
     */
    public function detail($id)
    {
        return true;
    }

    /**
     * @param Request $request
     *
     * @return collection
     */
    public function getBooking($start,$end){
        $bookings=Booking::all();
        $results=[];
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
        return $results;
    }
    public function getBookingRecur($start, $end)
    {
        $results=[];  
        // if(date('Y-m-d',strtotime($start))>\Carbon::now()->format('Y-m-d')){
            $recurs=Recur::all();
            foreach($recurs as $recur){
                $startDate=null;
                $days_repeat= $recur->days_repeat;
                if($recur->repeat_type==WEEKLY){
                    $startDate=date('Y-m-d', strtotime( $start.' + '.$days_repeat.' days'));
                }
                elseif($recur->repeat_type==MONTHLY){
                   
                    $day= self::getDateOfRecurMonthly($start,$end,$days_repeat );
                    if($day!=null){
                        $startDate=$day;
                    }
                }
                else{
                    $day=self::getDateOfRecurYearly($start,$end, $days_repeat);
                    if($day!==null)
                        $startDate=$day;

                }
                if($startDate!=null){
                    $results[]=[
                        'id'=>$recur->id,
                        'title' => $recur->title,
                        'description' => $recur->content,
                        'start' => $startDate.' '. $recur->start_time,
                        'end' => $startDate.' '.$recur->end_time,
                        'textColor'=>'#fff',
                        'color'=>$recur->color,
                    ];
                }
            }
        // }
        return $results;
    }

    
    public function getDateOfRecurMonthly($startDate, $endDate, $currentDate){

        $startDay=date('d',strtotime($startDate));
        $startMonth=date('m',strtotime($startDate));
        $startYear=date('Y',strtotime($startDate));
        $endDay=date('d',strtotime($endDate));
        $endMonth=date('m',strtotime($endDate));
        $endYear=date('Y',strtotime($endDate));
        if($startMonth==$endMonth){
            // Ngày đầu tuần và cuối tuần cùng tháng
            // Ngày lặp thuộc tuần thì tạo ngày lặp cụ thể cho booking
            if($startDay<=$currentDate && $endDay>=$currentDate){
                $date=$startYear.'-'.$startMonth.'-'.$currentDate;
            }  
        }
        else {
            // đầu tuần và cuối tuần khác tháng
            if($startDay<=$currentDate){
                $date= $startYear.'-'.$startMonth.'-'.$currentDate;
            }
            else if($endDay>=$currentDate){
                $date= $startYear.'-'.$endMonth.'-'.$currentDate;
            }            
        }
        if(isset($date)) return $date;
        return null;
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
        // Nếu ngày đầu tuần và cuối tuần cùng một năm thì lấy năm đó để add booking
        if($startYear==$endYear){
            $date=date('Y-m-d',strtotime($startYear.'-'.$currentDate));
        }
        // Nếu ngày đầu tuấn và cuối tuần khác năm thì tháng bắt đầu sẽ là 12, tháng kết thúc là 1
        else{
        // Ngày lặp lại thuộc tháng 12 thì lấy năm của đầu tuần là năm của booking
            if($currentMonth==12)
                $date=date('Y-m-d',strtotime($startYear.'-'.$currentDate));
            
        // Ngày lặp lại thuộc tháng 1 thì năm của booking được add là năm của ngày cuối tuấn   
            else if ($currentMonth==1)
                $date=date('Y-m-d',strtotime($endYear.'-'.$currentDate));
             
        }
        // Kiểm tra ngày lặp lại có nằm trong tuần không
         if($firstDayOfWeek<=$date && $date<=$lastDayOfWeek)
            return $date;
         else return null;
    }
}
