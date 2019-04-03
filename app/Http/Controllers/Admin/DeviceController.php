<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Repositories\Contracts\IDeviceRepository;
use App\Services\Contracts\IDeviceUserService;
use App\Traits\Controllers\ResourceController;
use Illuminate\Http\Request;

/**
 * DeviceController
 * Author: jvb
 * Date: 2019/03/11 06:46
 */
class DeviceController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.devices';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::devices';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Device::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Quản lý thiết bị';

    protected $resourceSearchExtend = 'admin.devices._search_extend';

    protected $resourceAllocate = 'admin.devices.allocate';

    protected $deviceUserService;

    /**
     * Controller construct
     */
    public function __construct(IDeviceRepository $repository, IDeviceUserService $deviceUserService)
    {
        $this->repository = $repository;
        $this->deviceUserService = $deviceUserService;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'types_device_id' => 'required',
                'name' => 'required'
            ],
            'messages' => [],
            'attributes' => [
                'types_device_id' => 'chủng loại',
                'name' => 'tên viết bị'
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'types_device_id' => 'required',
                'name' => 'required',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = $this->getResourceModel()::search($search);
        $type = $request->get('type');
        if (!is_null($type)) {
            $model = $model->where('types_device_id', $type);
        }
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'desc' : 'asc');
        } else {
            $model->orderBy('types_device_id', 'asc');
        }
        $model->pluck('total');
        return $model->paginate($perPage);
    }

}
