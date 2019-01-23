<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DayOffRequest;
use App\Models\DayOff;
use App\Models\User;
use App\Repositories\Contracts\IDayOffRepository;
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

    /**
     * Controller construct
     */
    public function __construct(IDayOffRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
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
