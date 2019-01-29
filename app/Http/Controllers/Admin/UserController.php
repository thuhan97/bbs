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
                'birthday' => 'date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'min:10|max:30|unique:users,phone',
                'id_card' => 'min:9|max:12|unique:users,id_card',
            ],
            'messages' => [],
            'attributes' => [],
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
                'birthday' => 'date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'min:10|max:30|unique:users,phone,' . $record->id,
                'id_card' => 'min:9|max:12|unique:users,id_card,' . $record->id,
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

}
