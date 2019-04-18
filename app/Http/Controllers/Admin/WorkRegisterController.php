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
    protected $WORK_PATH;
    const SELECT_TYPE = [
        'QUICK_SELECT_TYPE' => [
            'value' => 0,
            'name' => 'type_1'
        ],
        'DETAIL_SELECT_TYPE' => [
            'value' => 1,
            'name' => 'type_2'
        ],
        'DETAIL_TIME_SELECT_TYPE' => [
            'value' => 2,
            'name' => 'type_3'
        ],
    ];
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
        $settings = app('settings')->first();
        $this->WORK_PATH = [
            0 => [
                'start_at' => $settings['morning_start_work_at'],
                'end_at' => $settings['morning_end_work_at']
            ],
            1 => [
                'start_at' => $settings['afternoon_start_work_at'],
                'end_at' => $settings['afternoon_end_work_at']
            ],
            2 => [
                'start_at' => 0,
                'end_at' => 0
            ],
            3 => [
                'start_at' => $settings['morning_start_work_at'],
                'end_at' => $settings['afternoon_end_work_at']
            ]
        ];

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
        $record = WorkTimeRegister::where('user_id', $id)->first();
        if (empty($record)) {
            $createDefaultArray = [];
            for ($i = 2; $i <= 7; $i++) {
                $createDefaultArray[] = [
                    'start_at' => $this->WORK_PATH[0]['start_at'],
                    'end_at' => $this->WORK_PATH[0]['end_at'],
                    'user_id' => $id,
                    'select_type' => self::SELECT_TYPE['DETAIL_TIME_SELECT_TYPE']['value'],
                    'day' => $i
                ];
            }
            if (WorkTimeRegister::insert($createDefaultArray)) {
                $record = WorkTimeRegister::where('user_id', $id)->first();
            } else {
                abort(404);
            }
        }

        $this->authorize('update', $record);

        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsEditViewData(['id' => $id]),
        ]));
    }

    public function addVarsEditViewData($data = [])
    {
        $oldValue = [];
        $payload = $this->repository->findIn('user_id', [$data['id']]);

        $payload->each(function ($item) use (&$oldValue) {
            $oldValue[] = $item->only('start_at', 'end_at');
        });

        // minimize this later
        foreach ($oldValue as $key => $item) {
            if ($item == $this->WORK_PATH[3]) {
                $oldValue[self::SELECT_TYPE['DETAIL_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = 3;
            } elseif ($item['start_at'] == $this->WORK_PATH[0]['start_at'] && $item['end_at'] == $this->WORK_PATH[0]['end_at']) {
                $oldValue[self::SELECT_TYPE['DETAIL_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = 0;
            } elseif ($item['start_at'] == '00:00:00' || $item['end_at'] == '00:00:00') {
                $oldValue[self::SELECT_TYPE['DETAIL_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = 2;
            } elseif ($item['start_at'] == $this->WORK_PATH[1]['start_at'] && $item['end_at'] == $this->WORK_PATH[1]['end_at']) {
                $oldValue[self::SELECT_TYPE['DETAIL_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = 1;
            } else {
                $oldValue[self::SELECT_TYPE['DETAIL_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = 0;
            }

            $oldValue[self::SELECT_TYPE['DETAIL_TIME_SELECT_TYPE']['name']][PART_OF_THE_DAY[$key]] = $item;
        }

        if ($oldValue[0]['start_at'] == $this->WORK_PATH[0]) {
            $oldValue[self::SELECT_TYPE['QUICK_SELECT_TYPE']['name']] = 0;
        } else {
            $oldValue[self::SELECT_TYPE['QUICK_SELECT_TYPE']['name']] = 1;
        }
        // ---

        Session::flash('currentId', $payload->first()->select_type);
        $addVarsForView['edit_title'] = $this->editTitle;
        $addVarsForView['edit_target'] = $this->service->findOneUser($data['id'])->name;
        $addVarsForView['old_value'] = collect($oldValue)->except(0, 1, 2, 3, 4, 5)->toArray();
        $addVarsForView['payload'] = $payload;

        return $addVarsForView;
    }

    public function update(Request $request, $id)
    {
        $request->session()->flash('currentId', $request->select_type);
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $this->resourceValidate($request, 'update', $record);
        $valuesToSave = $this->getValuesToSave($request, $id);

        if ($this->service->update($id, $valuesToSave)) {
            flash()->success('Cập nhật thành công.');

            return $this->getRedirectAfterSave($record, $request,$isCreate = false

            );
        } else {
            flash()->info('Cập nhật thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    public function getValuesToSave(Request $request, $record = null)
    {
        $valuesToSave = $this->requestAnalyze($request);
        foreach ($valuesToSave as $key => &$value) {
            if (is_numeric($key)) {
                $value['select_type'] = $request->select_type;
                $value['user_id'] = $record;
                $value['day'] = intval($key) + 2;
            }
        }

        return $valuesToSave;
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
        if ($request->select_type == self::SELECT_TYPE['QUICK_SELECT_TYPE']['value']) {
            for ($i = 0; $i <= 5; $i++) {
                $payload[] = $this->WORK_PATH[$request->quick_part];
            }
        } elseif ($request->select_type == self::SELECT_TYPE['DETAIL_SELECT_TYPE']['value']) {
            foreach ($request->all($this->keys) as $item) {
                $payload[] = $this->WORK_PATH[$item];
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
