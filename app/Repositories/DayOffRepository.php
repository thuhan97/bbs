<?php 
namespace App\Repositories;

use App\Models\DayOff;
use App\Repositories\Contracts\IDayOffRepository;

/**
* DayOffRepository class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class DayOffRepository extends AbstractRepository implements IDayOffRepository
{
     /**
     * DayOffModel
     *
     * @var  string
     */
	  protected $modelName = DayOff::class;
}
