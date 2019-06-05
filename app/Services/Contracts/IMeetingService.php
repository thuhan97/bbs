<?php

namespace App\Services\Contracts;

use App\Models\Meeting;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


interface IMeetingService extends IBaseService
{


    /**
     * @param $start, $end
     *
     * @return collection
     */
    public function getMeetings($start,$end);

    public function getBookings($start,$end);

    /**
     * @param int $id
     *
     * @return Event
     */
    public function detail($id);





}
