<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DayOffRequest;
use App\Models\DayOff;
use App\Models\RemainDayoff;
use App\Models\User;
use App\Repositories\Contracts\IDayOffRepository;
use App\Services\Contracts\IDayOffService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * DayOffController
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class DayOffController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.day_off';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::day_offs';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = DayOff::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Ngày nghỉ phép';

    protected $resourceSearchExtend = 'admin.day_off._search_extend';

    /**
     * @var IDayOffService
     */
    private $service;

    /**
     * Controller construct
     *
     * @param IDayOffRepository $repository
     * @param IDayOffService    $service
     */
    public function __construct(IDayOffRepository $repository, IDayOffService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function byUser(Request $request, $id)
    {
        $totalDayOfff=$this->service->countDayOff($id,true);
        $remainDayOff=RemainDayoff::select('remain')->where('user_id',$id)->where('year',date('Y'))->first();
        $user = User::where('id', $id)->first();
        if ($user) {
            $conditions = ['user_id' => $id];

            $records = $this->service->findList($request, $conditions, ['*'], $search, $perPage);
            $year = $request->get('year');
            $month = $request->get('month');
           $numberThisYearAndLastYear= $this->service->getDayOffUser($id);
            return view($this->resourceAlias . '.user', compact('user', 'records', 'search', 'perPage', 'year', 'month', 'numberThisYearAndLastYear','totalDayOfff','remainDayOff'));
        } else {
            flash()->error(__l('user_not_found'));
            return redirect(route('admin::day_offs.index'));
        }
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function filterCreateViewData($data = [])
    {
        return $this->makeRelationData($data);
    }

    /**
     * @param       $record
     * @param array $data
     *
     * @return array
     */
    public function filterEditViewData($record, $data = [])
    {

        return $this->makeRelationData($data);

    }

    public function resourceStoreValidationData()
    {
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData();
    }

    /**
     * @param Request $request
     * @param         $values
     *
     * @return mixed
     */
    public function alterValuesToSave(Request $request, $values)
    {
        if (empty($values['approver_at']) && !empty($values['approver_id'])) {
            $values['approver_at'] = Carbon::now();
        }

        return $values;
    }

    private function validationData()
    {
        $questionRequest = new DayOffRequest();
        return [
            'rules' => $questionRequest->rules(),
            'messages' => $questionRequest->messages(),
            'attributes' => $questionRequest->attributes(),
            'advanced' => [],
        ];
    }

    private function makeRelationData($data = [])
    {
        $userModel = new User();
        $data['request_users'] = $userModel->availableUsers()->pluck('name', 'id')->toArray();
        $data['approver_users'] = $userModel->approverUsers()->pluck('name', 'id')->toArray();

        return $data;
    }
}
