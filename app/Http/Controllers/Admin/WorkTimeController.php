<?php

namespace App\Http\Controllers\Admin;

use App\Facades\AuthAdmin;
use App\Http\Requests\Admin\WorkTimeImportRequest;
use App\Http\Requests\Admin\WorkTimeRequest;
use App\Imports\WorkTimeImport;
use App\Models\User;
use App\Models\WorkTime;
use App\Models\WorkTimesExplanation;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Services\Contracts\IWorkTimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

/**
 * WorkTimeController
 * Author: jvb
 * Date: 2019/01/22 10:50
 */
class WorkTimeController extends AdminBaseController
{

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.work_time';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::work_times';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = WorkTime::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Giờ làm việc';

    protected $resourceSearchExtend = 'admin.work_time._search_extend';

    private $sevice;

    /**
     * Controller construct
     *
     * @param IWorkTimeRepository $repository
     * @param IWorkTimeService $service
     */
    public function __construct(IWorkTimeRepository $repository, IWorkTimeService $service)
    {
        $this->repository = $repository;
        $this->sevice = $service;
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import()
    {
        return view('admin.work_time.import', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]);
    }

    /**
     * @param WorkTimeImportRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importData(WorkTimeImportRequest $request)
    {
        //Do validation file
        $extensions = array("xls", "xlsx", "xlm", "xla", "xlc", "xlt", "xlw", "csv");
        $fileExtension = $request->file('import_file')->getClientOriginalExtension();
        $request->merge(['ext' => strtolower($fileExtension)]);
        $this->validate($request, [
            'ext' => 'in:' . implode(',', $extensions),
        ], [
            'ext.in' => __('validation.file_extension_invalid')
        ]);

        $importErrors = [];
        \DB::beginTransaction();

        //Delete current data
        WorkTime::whereYear('work_day', $request->get('year'))
            ->whereMonth('work_day', $request->get('month'))
            ->delete();
        $importFile = request()->file('import_file');// $request->file('import_file');
        //Import from file
        Excel::import(new WorkTimeImport(), $importFile);

        \DB::commit();

        $message = 'Nhập dữ liệu thành công.';

        return view('admin.work_time.import', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'import_errors' => $importErrors,
            'message' => $message
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        $pathToFile = public_path('/template/mau-cham-cong.xls');
        return response()->download($pathToFile);
    }

    public function getRedirectAfterSave($record, $request)
    {
        $explanationID = $request->explanation_id;
        $explanationNote = $request->explanation_note;
        $idUser = Auth::id();
        if ($explanationID) {
            $data = WorkTimesExplanation::where('id', $explanationID)->first();
            $data->note = $explanationNote;
            $data->save();
        } else {
            WorkTimesExplanation::create([
                'user_id' => $idUser,
                'work_day' => $record->work_day,
                'note' => $explanationNote
            ]);
        }
        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * @return array
     */
    private function validationData()
    {
        $questionRequest = new WorkTimeRequest();
        return [
            'rules' => $questionRequest->rules(),
            'messages' => $questionRequest->messages(),
            'attributes' => $questionRequest->attributes(),
            'advanced' => [],
        ];
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

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        return $this->sevice->search($request, $perPage, $search);
    }

    /**
     * @param Request $request
     * @param         $values
     *
     * @return mixed
     */
    public function alterValuesToSave(Request $request, $values)
    {
        return $values;
    }

    private function makeRelationData($data = [])
    {
        $userModel = new User();
        $data['request_users'] = $userModel->availableUsers()->pluck('name', 'id')->toArray();

        return $data;
    }
}
