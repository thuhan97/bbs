<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rules;
use App\Repositories\Contracts\IRulesRepository;

/**
 * RulesController
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
class RulesController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.rules';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::rules';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Rules::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Quy định tiền phạt';

    /**
     * Controller construct
     */
    public function __construct(IRulesRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData();
    }

    public function validationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'penalize' => 'required|numeric|min:1000|max:10000000',
                'detail' => 'max:255',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên vi phạm',
                'penalize' => 'tiền phạt',
                'detail' => 'nội dung chi tiết',
            ],
            'advanced' => [],
        ];
    }

}
