<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DayOff;
use App\Repositories\Contracts\IDayOffRepository;
use App\Traits\Controllers\ResourceController;

/**
 * DayOffController
 * Author: jvb
 * Date: 2019/01/22 10:50
*/
class DayOffController extends Controller
{
    use ResourceController;

    /**
     * @var  string
    */
    protected $resourceAlias = 'admin.dayoffs';

    /**
     * @var  string
    */
    protected $resourceRoutesAlias = 'admin::dayoffs';

    /**
     * Fully qualified class name
     *
     * @var  string
    */
    protected $resourceModel = DayOff::class;

    /**
     * @var  string
    */
    protected $resourceTitle = 'DayOff';

    /**
     * Controller construct
    */
    public function __construct(IDayOffRepository $repository)
    {
        $this->repository = $repository;
    }

}
