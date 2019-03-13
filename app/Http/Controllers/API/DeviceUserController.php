<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\Contracts\IDeviceService;
use App\Services\Contracts\IEventService;
use App\Traits\RESTActions;
use App\Transformers\DeviceTransformer;
use App\Transformers\EventTransformer;
use Illuminate\Http\Request;

class DeviceUserController extends Controller
{
    use RESTActions;

    /**
     * @var IEventService
     */
    private $eventService;

    /**
     * EventController constructor.
     *
     * @param IEventService    $eventService
     * @param EventTransformer $transformer
     */
    public function __construct(
        IDeviceService $deviceService,
        DeviceTransformer $transformer
    )
    {
        $this->deviceService = $deviceService;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDevices(Request $request) {
        $this->validate($request, [
            'types_device_id' => 'required'
        ]);
        if ($request->get('types_device_id')) {
            $devices = Device::where('final', '>', 0)->select('id', 'name', 'types_device_id')->get();
        } else {
            $devices = $this->deviceService->getDevicesByType($request->get('types_device_id'));
        }

        return $this->respondTransformer($devices);
    }

}
