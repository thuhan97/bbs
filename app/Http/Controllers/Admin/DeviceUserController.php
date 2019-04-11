<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use App\Models\DeviceUser;
use App\Repositories\Contracts\IDeviceRepository;
use App\Repositories\Contracts\IDeviceUserRepository;
use App\Services\Contracts\IDeviceUserService;
use App\User;
use Illuminate\Http\Request;

/**
 * DeviceUserController
 * Author: jvb
 * Date: 2019/03/12 02:45
 *
 * @property IDeviceRepository  deviceRepository
 * @property IDeviceUserService service
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
    public function __construct(IDeviceUserRepository $repository, IDeviceUserService $service, IDeviceRepository $deviceRepository)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->deviceRepository = $deviceRepository;
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
    public function allocate($id)
    {
        $record = Device::where('id', $id)->select('id as devices_id', 'types_device_id')->first();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $devicesId = $request->get('devices_id');
        $device = $this->deviceRepository->findOne($devicesId);
        \DB::beginTransaction();
        if ($device->final > 0) {
            $dataUpdate = [
                'month_of_use' => (int)$device['month_of_use'] + 1,
                'final' => (int)$device['final'] - 1
            ];
            $this->deviceRepository->update($device, $dataUpdate);
            $valuesToSave = $this->getValuesToSave($request);
            $request->merge($valuesToSave);
            $this->resourceValidate($request, 'store');

            if ($record = $this->repository->save($this->alterValuesToSave($request, $valuesToSave))) {
                flash()->success('Thêm mới thành công.');
                \DB::commit();
                return $this->getRedirectAfterSave($record, $request);
            } else {
                flash()->info('Thêm mới thất bại.');
            }
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }
}
