<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\WorkTimeRegister;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTimeRegisterRepository;
use App\Services\Contracts\IWorkTimeRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WorkRegisterController extends AdminBaseController
{
    protected $editTitle = 'Sửa thời gian làm việc';
    protected $subTitle = 'Danh sách nhân viên không làm full time';
    private $ableToRegister = [1, 2, 3];
    private $keys = ['mon_part', 'tue_part', 'wed_part', 'thu_part', 'fri_part', 'sat_part'];
    protected $service;
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.work_time_register';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::work_time_register';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = WorkTimeRegister::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Đăng ký thời gian làm việc';

    protected $resourceSearchExtend = 'admin.work_time_register._search_extend';

    /**
     * Controller construct
     */
    public function __construct(IWorkTimeRegisterRepository $repository, IWorkTimeRegisterService $service, IUserRepository $userRepository)
    {
        $this->service = $service;
        $this->repository = $repository;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());

        $records = $this->searchRecords($request, $perPage, $search);
        $addVarsForView['_pageSubtitle'] = $this->subTitle;

        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'records' => $records,
            'search' => $search,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
            'resourceSearchExtend' => $this->resourceSearchExtend,
            'addVarsForView' => $addVarsForView,
        ]));
    }

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = User::whereIn('contract_type', $this->ableToRegister);
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('id', 'desc');
        }

        return $model->paginate($perPage);
    }

    public function show($id)
    {
        $record = $this->service->findOne($id);

        $this->authorize('update', $record);

        return view($this->getResourceShowPath(), $this->filterShowViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
    }

    public function edit($id)
    {
        $record = [];
        $oldValue = [];
        $payload = $this->repository->findIn('user_id', [$id]);
        $payload->each(function ($item) use (&$oldValue) {
            $oldValue[] = $item->only('start_at', 'end_at');
        });

        foreach ($oldValue as $key => $item) {
            if ($item == WORK_PATH[3]) {
                $oldValue['type_2'][PART_OF_THE_DAY[$key]] = 3;
            } elseif ($item['start_at'] == WORK_PATH[0]['start_at'] && $item['end_at'] == WORK_PATH[0]['end_at']) {
                $oldValue['type_2'][PART_OF_THE_DAY[$key]] = 0;
            } elseif ($item['start_at'] == '00:00:00' || $item['end_at'] == '00:00:00') {
                $oldValue['type_2'][PART_OF_THE_DAY[$key]] = 2;
            } elseif ($item['start_at'] == WORK_PATH[1]['start_at'] && $item['end_at'] == WORK_PATH[1]['end_at']) {
                $oldValue['type_2'][PART_OF_THE_DAY[$key]] = 1;
            } else {
                $oldValue['type_2'][PART_OF_THE_DAY[$key]] = 0;
            }

            $oldValue['type_3'][PART_OF_THE_DAY[$key]] = $item;
        }

        if ($oldValue[0]['start_at'] == WORK_PATH[0]) {
            $oldValue['type_1'] = 0;
        } else {
            $oldValue['type_1'] = 1;
        }

        Session::flash('currentId', $payload->first()->select_type);

        $this->authorize('update', $record);
        $addVarsForView['edit_title'] = $this->editTitle;
        $addVarsForView['edit_target'] = $this->service->findOneUser($id)->name;
        $oldValue = collect($oldValue)->except(0, 1, 2, 3, 4, 5)->toArray();

        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'payload' => $payload,
            'oldValue' => $oldValue,
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $addVarsForView,
        ]));
    }

    public function update(Request $request, $id)
    {
        $request->session()->flash('currentId', $request->select_type);
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $valuesToSave = $this->getValuesToSave($request, $record);
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'update', $record);
        $payload = $this->requestAnalyze($request);

        foreach ($payload as $key => &$value) {
            if (is_numeric($key)) {
                $value['select_type'] = $request->select_type;
                $value['user_id'] = $id;
                $value['day'] = intval($key) + 2;
            }
        }

        if ($this->service->update($id, $payload)) {
            flash()->success('Cập nhật thành công.');

            return $this->getRedirectAfterSave($record, $request);
        } else {
            flash()->info('Cập nhật thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    public function resourceUpdateValidationData($record)
    {
        $validateOptions = [
            'rules' => [
                'select_type' => 'required|numeric|between:0,2',
                'quick_part' => 'nullable|between:0,3',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];

        foreach (PART_OF_THE_DAY as $item) {
            $validateOptions['rules'][$item . '_part'] = 'nullable|numeric|between:0,3';
            $validateOptions['rules'][$item . '_start'] = 'nullable|max:8';
            $validateOptions['rules'][$item . '_end'] = 'nullable|max:8';
        }

        return $validateOptions;
    }

    private function requestAnalyze(Request $request)
    {
        $payload = [];
        if ($request->select_type == 0) {
            for ($i = 0; $i <= 5; $i++) {
                $payload[] = WORK_PATH[$request->quick_part];
            }
        } elseif ($request->select_type == 1) {
            foreach ($request->all($this->keys) as $item) {
                $payload[] = WORK_PATH[$item];
            }
        } else {
            foreach (PART_OF_THE_DAY as $key => $item) {
                $payload[$key]['start_at'] = $request[$item . '_start'];
                $payload[$key]['end_at'] = $request[$item . '_end'];
            }
        }

        return $payload;
    }
}
