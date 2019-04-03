<?php
/**
 * ReportService class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */

namespace App\Services;

use App\Models\Meeting;
use App\Repositories\Contracts\IMeetingRepository;
use App\Services\Contracts\IMeetingService;
use Illuminate\Http\Request;

class MeetingService extends AbstractService implements IMeetingService
{
    /**
     * ReportService constructor.
     *
     * @param \App\Models\Report                            $model
     * @param \App\Repositories\Contracts\IReportRepository $repository
     */
    public function __construct(Meeting $model, IMeetingRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    
}
