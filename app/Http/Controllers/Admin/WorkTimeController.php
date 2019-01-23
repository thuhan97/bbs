<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkTime;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Traits\Controllers\ResourceController;

/**
 * WorkTimeController
 * Author: jvb
 * Date: 2019/01/22 10:50
*/
class WorkTimeController extends Controller
{
    use ResourceController;

    /**
     * @var  string
    */
    protected $resourceAlias = 'admin.worktimes';

    /**
     * @var  string
    */
    protected $resourceRoutesAlias = 'admin::worktimes';

    /**
     * Fully qualified class name
     *
     * @var  string
    */
    protected $resourceModel = WorkTime::class;

    /**
     * @var  string
    */
    protected $resourceTitle = 'WorkTime';

    /**
     * Controller construct
    */
    public function __construct(IWorkTimeRepository $repository)
    {
        $this->repository = $repository;
    }

}
