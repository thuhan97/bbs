<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.manager';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::manager';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Manager::class;


//    protected $resourceSearchExtend = 'admin.teams._search_extend';

    /**
     * @var  string
     */
    protected $resourceTitle = 'Cấp quản lý';


    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:50',
                'manger' => 'required|max:50',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:50',
                'manger' => 'required|max:50',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }


}
