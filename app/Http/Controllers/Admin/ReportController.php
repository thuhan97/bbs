<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Repositories\Contracts\IReportRepository;
use App\Traits\Controllers\ResourceController;

/**
 * ReportController
 * Author: trinhnv
 * Date: 2019/01/21 03:42
 */
class ReportController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.reports';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::reports';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Report::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Report';

    /**
     * Controller construct
     */
    public function __construct(IReportRepository $repository)
    {
        $this->repository = $repository;
    }


}
