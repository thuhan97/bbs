<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Contracts\IAdminRepository;
use App\Traits\Controllers\ResourceController;

/**
 * AdminController
 * Author: trinhnv
 * Date: 2018/09/03 01:52
 */
class AdminController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.admins';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::admins';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Admin::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Admin';

    /**
     * Controller construct
     */
    public function __construct(IAdminRepository $repository)
    {
        $this->repository = $repository;
    }

}
