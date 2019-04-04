<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Request;

/**
 * UserController
 * Author: jvb
 * Date: 2018/07/16 10:24
 */
class UserController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.users';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::users';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = User::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Nhân viên';

    protected $resourceSearchExtend = 'admin.users._search_extend';

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'filled|max:255',
                'email' => 'email|unique:users,email',
                'staff_code' => 'filled|max:10|unique:users,staff_code',
                'birthday' => 'nullable|date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'nullable|min:10|numeric|max:30|unique:users,phone',
                'id_card' => 'nullable|min:9|max:12|unique:users,id_card',
                'password'=>'required|same:password_confirmation',
                'password_confirmation'=>'required',
                'start_date'=>'nullable|date',
                'end_date'=>"nullable|date|after:start_date"
            ],
            'messages' => [
                'end_date.after'=>'Ngày nghỉ việc phải là ngày sau ngày vào công ty',
                'numeric'=> ":attribute phải là định dạng số"
            ],
            'attributes' => ['phone'=>'Số điện thoại'],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,' . $record->id,
                'staff_code' => 'filled|max:10|unique:users,staff_code,' . $record->id,
                'birthday' => 'nullable|date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'nullable|min:10|numeric|max:30|unique:users,phone,' . $record->id,
                'id_card' => 'nullable|min:9|max:12|unique:users,id_card,' . $record->id,
                'password'=>'nullable|same:password_confirmation',
                'start_date'=>'nullable|date',
                'end_date'=>"nullable|date|after:start_date"
            ],
            'messages' => ['numeric'=> ":attribute phải là định dạng số"],
            'attributes' => [
                'end_date.after'=>'Ngày nghỉ việc phải là ngày sau ngày vào công ty',
                'phone'=>'Số điện thoại'
            ],
            'advanced' => [],
        ];
    }
    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $model = $this->getResourceModel()::search($search);

        $jobtitle_id = $request->get('jobtitle');
        if (!empty($jobtitle_id)) {
            $model = $model->where('jobtitle_id', $jobtitle_id);
        }
        $position_id = $request->get('position');

        if (!empty($position_id)) {
            $model = $model->where('position_id', $position_id);
        }
        $contract_type = $request->get('contract_type');
        if (!empty($contract_type)) {
            $model = $model->where('contract_type', $contract_type);
        }

        if ($request->has('sort')) {
            $model->orderBy($request->get('sort'), $request->get('is_desc') ? 'asc' : 'desc');
        } else {
            $model->orderBy('id', 'desc');
        }

        return $model->paginate($perPage);
    }

    public function resetPassword(Request $request)
    {
        $isAll = $request->get('is_all', false);
        if ($isAll) {
            $users = User::all();
        } else {
            $this->validate($request, [
                'user_ids' => 'required',
            ]);
            $user_ids = $request->get('user_ids');
            if (!is_array($user_ids)) {
                $user_ids = [$user_ids];
            }
            $users = User::whereIn('id', $user_ids)->get();
        }
        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $user->password = $user->staff_code;
                $user->save();
            }
            flash()->success('Reset mật khẩu thành công');
        } else {
            flash()->error('Không tìm thấy nhân viên');
        }
        return redirect(route('admin::users.index'));
    }
}
