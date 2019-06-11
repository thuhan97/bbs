<?php
/**
 * MeetingRoomService class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */

namespace App\Services;

use App\Models\MeetingRoom;
use App\Repositories\Contracts\IMeetingRoomRepository;
use App\Services\Contracts\IMeetingRoomService;

class MeetingRoomService extends AbstractService implements IMeetingRoomService
{
    /**
     * ReportService constructor.
     *
     * @param \App\Models\Report                            $model
     * @param \App\Repositories\Contracts\IReportRepository $repository
     */
    public function __construct(MeetingRoom $model, IMeetingRoomRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }


}
