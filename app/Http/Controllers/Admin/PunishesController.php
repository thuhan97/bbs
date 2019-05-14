<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PunishRequest;
use App\Models\Punishes;
use App\Models\Rules;
use App\Models\User;
use App\Repositories\Contracts\IPunishesRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * PunishesController
 * Author: jvb
 * Date: 2019/04/22 08:21
 */
class PunishesController extends AdminBaseController
{
    public $defaultPageSize = 50;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.punishes';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::punishes';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Punishes::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Danh sách vi phạm';

    protected $resourceSearchExtend = 'admin.punishes._search_extend';

    /**
     * Controller construct
     */
    public function __construct(IPunishesRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = $this->getSearchModel($request, $search);

        $rule_id = $request->get('rule_id');
        if (!empty($rule_id)) {
            $model = $model->where('rule_id', $rule_id);
        }
        $user_id = $request->get('user_id');
        if (!empty($user_id)) {
            $model = $model->where('user_id', $user_id);
        }
        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('id', 'desc');
        }

        return $model->paginate($perPage);
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
        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
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
        $questionRequest = new PunishRequest();
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
        $data['users'] = $userModel->availableUsers()->select(DB::raw('CONCAT(staff_code, " - ", name) as name'), 'id')->pluck('name', 'id')->toArray();
        $data['rules'] = Rules::select(DB::raw('CONCAT(name, " - ", FORMAT(penalize, 0)) as rule'), 'id')->pluck('rule', 'id')->toArray();

        return $data;
    }

    public function submit(Request $request)
    {

    }

    public function changeSubmitStatus($id)
    {
        $punish = Punishes::find($id);

        if ($punish) {
            $punish->is_submit ^= true;
            $punish->save();
            flash()->success('Cập nhật thành công!');
        } else {
            flash()->error('Không tìm thấy bản ghi!');
        }
        return redirect(route('admin::punishes.index'));
    }

    public function submits(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array'
        ]);
        $ids = $request->get('ids');
        Punishes::whereIn('id', $ids)->update([
            'is_submit' => Punishes::SUBMITED
        ]);
        flash()->success('Cập nhật thành công!');

        return redirect(route('admin::punishes.index'));
    }

    /**
     * @param Request $request
     * @param         $search
     *
     * @return mixed
     */
    protected function getSearchModel(Request $request, $search)
    {
        $year = $request->get('year') ?? date('Y');

        $model = $this->getResourceModel()::search($search);
        $model->whereYear('infringe_date', $year);
        $month = $request->get('month');
        if ($month) {
            $model->whereMonth('infringe_date', $month);
        }
        $is_submit = $request->get('is_submit');
        if (isset($is_submit)) {
            $model->where('is_submit', $is_submit);
        }
        return $model;
    }
}
