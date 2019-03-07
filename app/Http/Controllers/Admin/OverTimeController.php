<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OverTime;
use App\Repositories\Contracts\IOverTimeRepository;
use App\Traits\Controllers\ResourceController;

/**
 * OverTimeController
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class OverTimeController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.overtimes';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::overtimes';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = OverTime::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'OverTime';

    /**
     * Controller construct
     */
    public function __construct(IOverTimeRepository $repository)
    {
        $this->repository = $repository;
    }

}
