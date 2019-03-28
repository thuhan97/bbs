<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkTimeDetail;
use App\Repositories\Contracts\IWorkTimeDetailRepository;
use App\Traits\Controllers\ResourceController;

/**
 * WorkTimeDetailController
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class WorkTimeDetailController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.worktimedetails';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::worktimedetails';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = WorkTimeDetail::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'WorkTimeDetail';

    /**
     * Controller construct
     */
    public function __construct(IWorkTimeDetailRepository $repository)
    {
        $this->repository = $repository;
    }

}
