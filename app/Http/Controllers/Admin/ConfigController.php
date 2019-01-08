<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Repositories\Contracts\IConfigRepository;

/**
 * ConfigController
 * Author: trinhnv
 * Date: 2018/11/15 16:31
 */
class ConfigController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.config';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::configs';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Config::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Config';

    /**
     * Controller construct
     */
    public function __construct(IConfigRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

}
