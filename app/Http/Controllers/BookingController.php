<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Recur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\RESTActions;
use App\Services\Contracts\IBookingService;
use Carbon;
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
		
		return view('end_user.booking.calendar');
	}

	public function getCalendar(Request $request){
		
		$start= $request->start;
		$end= $request->end;
		$results=$this->bookingService->getBooking();
		$results=array_merge($results,$this->bookingService->getBookingRecur($start,$end));

        return $this->respond(['bookings' => $results]);
	}
}