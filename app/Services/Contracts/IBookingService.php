<?php

namespace App\Services\Contracts;

use App\Models\Booking;
use App\Models\Recur;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

 
interface IBookingService extends IBaseService
{
    

    /**
     * @param $start, $end
     *
     * @return collection
     */
    public function getBooking();

    public function getBookingRecur($start,$end);

    /**
     * @param int $id
     *
     * @return Event
     */
    public function detail($id);

    



}
