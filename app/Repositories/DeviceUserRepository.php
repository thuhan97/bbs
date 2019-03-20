<?php

namespace App\Repositories;

use App\Models\DeviceUser;
use App\Repositories\Contracts\IDeviceUserRepository;

/**
 * DeviceUserRepository class
 * Author: jvb
 * Date: 2019/03/12 02:45
 */
class DeviceUserRepository extends AbstractRepository implements IDeviceUserRepository
{
    /**
     * DeviceUserModel
     *
     * @var  string
     */
    protected $modelName = DeviceUser::class;
}
