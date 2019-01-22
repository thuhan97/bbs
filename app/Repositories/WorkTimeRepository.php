<?php 
namespace App\Repositories;

use App\Models\WorkTime;
use App\Repositories\Contracts\IWorkTimeRepository;

/**
* WorkTimeRepository class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class WorkTimeRepository extends AbstractRepository implements IWorkTimeRepository
{
     /**
     * WorkTimeModel
     *
     * @var  string
     */
	  protected $modelName = WorkTime::class;
}
