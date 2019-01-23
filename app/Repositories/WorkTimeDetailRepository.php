<?php 
namespace App\Repositories;

use App\Models\WorkTimeDetail;
use App\Repositories\Contracts\IWorkTimeDetailRepository;

/**
* WorkTimeDetailRepository class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class WorkTimeDetailRepository extends AbstractRepository implements IWorkTimeDetailRepository
{
     /**
     * WorkTimeDetailModel
     *
     * @var  string
     */
	  protected $modelName = WorkTimeDetail::class;
}
