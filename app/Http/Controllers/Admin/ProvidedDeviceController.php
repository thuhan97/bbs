<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProvidedDeviceNoticeEvent;
use App\Models\ProvidedDevice;
use App\Models\UserTeam;
use App\Repositories\Contracts\IProvidedDeviceRepository;
use Illuminate\Http\Request;

/**
 * ProvidedDeviceController
 * Author: jvb
 * Date: 2019/06/17 14:30
 */
class ProvidedDeviceController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.provided_device';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::provided_device';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = ProvidedDevice::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Yêu cầu cấp thiết bị';

    /**
     * Controller construct
     */
    public function __construct(IProvidedDeviceRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = $this->getResourceModel()::search($search);
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('provided_device.id', 'desc');
        }
        return $model->whereIn('provided_device.status',ARRAY_STATUS_DEVICE)->paginate($perPage);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort(404);
    }
    public function getRedirectAfterSave($record, $request, $isCreate = null)
    {
        if (!$isCreate){
            event(new ProvidedDeviceNoticeEvent($record, TYPE_DEVICE['administrative_approval']));
        }
        return redirect()->route($this->getResourceRoutesAlias() . '.index');
    }

}
