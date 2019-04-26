<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DayOffExcel;
use App\Helpers\ExcelHelper;
use App\Http\Requests\Admin\DayOffRequest;
use App\Models\DayOff;
use App\Models\RemainDayoff;
use App\Models\User;
use App\Repositories\Contracts\IDayOffRepository;
use App\Services\Contracts\IDayOffService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
     * @param IDayOffService $service
     */
    public function __construct(IDayOffRepository $repository, IDayOffService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());
        $records = $this->searchRecords($request, $perPage, $search);
        $recordsExcel = $this->getSearchRecords($request, 1000000000, $search);

        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'records' => $records,
            'recordsExcel'=>$recordsExcel,
            'search' => $search,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
            'resourceSearchExtend' => $this->resourceSearchExtend,
            'addVarsForView' => $this->addVarsSearchViewData()
        ]));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function byUser(Request $request, $id)
    {
        $totalDayOfff = $this->service->countDayOff($id, true);
        $remainDayOff = RemainDayoff::select('remain')->where('user_id', $id)->where('year', date('Y'))->first();
        $user = User::where('id', $id)->first();
        if ($user) {
            $conditions = ['user_id' => $id];

            $records = $this->service->findList($request, $conditions, ['*'], $search, $perPage);
            $year = $request->get('year');
            $month = $request->get('month');
            $numberThisYearAndLastYear = $this->service->getDayOffUser($id);
            return view($this->resourceAlias . '.user', compact('user', 'records', 'search', 'perPage', 'year', 'month', 'numberThisYearAndLastYear', 'totalDayOfff', 'remainDayOff'));
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

    /**
     * @param         $record
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getRedirectAfterSave($record, $request, $isCreate = null)
    {
        if ($record->status == STATUS_DAY_OFF['active']) {
            $this->service->calculateDayOff($request, $record->id);
        }
        return redirect(route($this->getResourceRoutesAlias() . '.index'));
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

    public function statisticalDayOffExcel(Request $request)
    {
        if ($request->ids) {
            $ids = array_unique($request->ids);
            $datas = $this->service->statisticalDayOffExcel($ids);
            return Excel::download(new DayOffExcel($datas), 'tung.xlsx');

        }
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
