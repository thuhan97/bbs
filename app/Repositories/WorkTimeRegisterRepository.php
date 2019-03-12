<?php
/**
 * Created by PhpStorm.
 * User: MinhTD
 * Date: 2/26/2019
 * Time: 9:17 AM
 */

namespace App\Repositories;

use App\Models\WorkTimeRegister;
use App\Repositories\Contracts\IWorkTimeRegisterRepository;

class WorkTimeRegisterRepository extends AbstractRepository implements IWorkTimeRegisterRepository
{
    protected $modelName = WorkTimeRegister::class;

    public function getMemberName($id)
    {
        return $this->getModel()->where('id', $id)->first()->name ?? '';
    }
}