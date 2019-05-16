<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Repositories\Contracts\IGroupRepository;
use Illuminate\Http\Request;

class GroupController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.group';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::group';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Group::class;


//    protected $resourceSearchExtend = 'admin.teams._search_extend';

    /**
     * @var  string
     */
    protected $resourceTitle = 'Group';

    public function __construct(IGroupRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|min:3|max:50',
                'manager_id' => 'required|integer',
                'description' => 'nullable|min:3',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên group',
                'manager' => 'người quản lý',
                'description' => 'mô tả'
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:50',
                'manager_id' => 'required|integer',
                'description' => 'nullable|min:3',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên group',
                'manager' => 'người quản lý',
                'description' => 'mô tả'
            ],
            'advanced' => [],
        ];
    }

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = $this->getResourceModel()::search($search);
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('id');
        }

        return $model->paginate($perPage);
    }


}
