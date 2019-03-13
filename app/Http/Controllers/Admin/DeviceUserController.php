<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceUser;
use App\Repositories\Contracts\IDeviceUserRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IDeviceService;
use App\Services\Contracts\IDeviceUserService;
use App\Traits\Controllers\ResourceController;
use App\Transformers\DeviceTransformer;
use App\User;
use Illuminate\Http\Request;

/**
 * DeviceUserController
 * Author: jvb
 * Date: 2019/03/12 02:45
 */
class DeviceUserController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.deviceusers';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::deviceusers';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = DeviceUser::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Cấp thiết bị';

    /**
     * Controller construct
     */
    public function __construct(IDeviceUserRepository $repository, IDeviceUserService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'users_id' => 'required',
                'devices_id' => 'required'
            ],
            'messages' => [],
            'attributes' => [
                'users_id' => 'nhân viên',
                'devices_id' => 'thiết bị'
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'users_id' => 'required',
                'devices_id' => 'required',
            ],
            'messages' => [],
            'attributes' => [
                'users_id' => 'nhân viên',
                'devices_id' => 'thiết bị'
            ],
            'advanced' => [],
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allocate($id) {
        $record = Device::where('id', $id)->select('id as devices_id', 'types_device_id')->first();
        $this->authorize('create', $this->getResourceModel());
        $users = User::all('id', 'name');
        $devices = Device::all('id', 'name', 'types_device_id');
        $class = $this->getResourceModel();
        return view($this->getResourceCreatePath(), $this->filterCreateViewData([
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsCreateViewData(),
            'users' => $users,
            'devices' => $devices,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', $this->getResourceModel());
        $users = User::all('id', 'name');
        $devices = Device::all('id', 'name', 'types_device_id');
        $class = $this->getResourceModel();
        return view($this->getResourceCreatePath(), $this->filterCreateViewData([
            'record' => new $class(),
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsCreateViewData(),
            'users' => $users,
            'devices' => $devices,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $record = $this->service->findById($id);
        $users = User::all('id', 'name');
        $devices = Device::all('id', 'name', 'types_device_id');
        $this->authorize('update', $record);
        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsEditViewData(),
            'users' => $users,
            'devices' => $devices,
        ]));
    }
}
