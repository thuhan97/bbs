<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\WorkTimeRegister;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTimeRegisterRepository;
use App\Services\Contracts\IWorkTimeRegisterService;
use Illuminate\Http\Request;

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
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $addVarsForView['edit_title'] = $this->editTitle;
        $addVarsForView['target_user'] = $this->service->findOneUser($id);
        $addVarsForView['edit_target'] = $addVarsForView['target_user']->name;

        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $addVarsForView,
        ]));
    }

    public function update(Request $request, $id)
    {
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $valuesToSave = $this->getValuesToSave($request, $record);
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'update', $record);
        $payload = $this->requestAnalyze($request);

        foreach ($payload as $key => &$value) {
            if(is_numeric($key)){
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
                'select_type' => 'required|numeric|digits_between:0,2',
                'quick_part' => 'nullable|digits_between:0,3',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];

        foreach (PART_OF_THE_DAY as $item) {
            $validateOptions['rules'][$item . '_path'] = 'nullable|numeric|digits_between:0,3';
            $validateOptions['rules'][$item . '_start'] = 'nullable|alpha_num|max:5';
            $validateOptions['rules'][$item . '_end'] = 'nullable|alpha_num|max:5';
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
