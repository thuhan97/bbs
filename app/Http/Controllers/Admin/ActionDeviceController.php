<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionDevice;
use App\Repositories\Contracts\IActionDeviceRepository;
use App\Traits\Controllers\ResourceController;

/**
 * ActionDeviceController
 * Author: jvb
 * Date: 2019/03/11 06:49
 */
class ActionDeviceController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.actiondevices';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::actiondevices';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = ActionDevice::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'ActionDevice';

    /**
     * Controller construct
     */
    public function __construct(IActionDeviceRepository $repository)
    {
        $this->repository = $repository;
    }

}
