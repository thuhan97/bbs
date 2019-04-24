<?php

namespace App\Http\Controllers\Admin;

use App\Models\OverTime;
use App\Models\User;
use App\Repositories\Contracts\IOverTimeRepository;
use Illuminate\Http\Request;

class OverTimeController extends AdminBaseController
{
    //
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.over_times';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::over_times';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = OverTime::class;

    protected $meetingService;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Làm thêm';

    public function __construct(IOverTimeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function filterCreateViewData($data = [])
    {
        return $this->makeRelationData($data);
    }

    public function filterEditViewData($record, $data = [])
    {
        return $this->makeRelationData($data);
    }

    public function create(Request $request)
    {
        $user_id = $request->get('user_id');
        $this->authorize('create', $this->getResourceModel());

        $class = $this->getResourceModel();
        return view($this->getResourceCreatePath(), $this->filterCreateViewData([
            'record' => new $class(),
            'user_id' => $user_id,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
    }

    private function makeRelationData($data = [])
    {
        $userModel = new User();
        $data['request_users'] = $userModel->availableUsers()->pluck('name', 'id')->toArray();
        $data['approver_users'] = $userModel->approverUsers()->pluck('name', 'id')->toArray();
        return $data;
    }
}
