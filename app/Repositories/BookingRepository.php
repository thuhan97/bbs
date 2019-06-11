<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Contracts\IBookingRepository;

/**
 * EventRepository class
 * Author: jvb
 * Date: 2018/10/07 16:46
 */
class BookingRepository extends AbstractRepository implements IBookingRepository
{
    /**
     * EventModel
     *
     * @var  string
     */
    protected $modelName = Booking::class;


}
