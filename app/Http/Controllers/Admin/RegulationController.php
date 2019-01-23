<?php

namespace App\Http\Controllers\Admin;

use App\Models\Regulation;
use App\Repositories\Contracts\IRegulationRepository;

/**
 * RegulationController
 * Author: jvb
 * Date: 2019/01/11 09:23
 */
class RegulationController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.regulations';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::regulations';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Regulation::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Quy định, nội quy';

    /**
     * Controller construct
     */
    public function __construct(IRegulationRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

}
