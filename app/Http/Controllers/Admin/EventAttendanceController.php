<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventAttendance;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Traits\Controllers\ResourceController;

/**
 * EventAttendanceController
 * Author: jvb
 * Date: 2019/03/11 09:35
 */
class EventAttendanceController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.eventattendance';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::eventattendance';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = EventAttendance::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'EventAttendance';

    /**
     * Controller construct
     */
    public function __construct(IEventAttendanceRepository $repository)
    {
        $this->repository = $repository;
    }

}
