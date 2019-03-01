<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventAttendanceList;
use App\Repositories\Contracts\IEventAttendanceListRepository;
use App\Traits\Controllers\ResourceController;

/**
* EventAttendanceListController
* Author: jvb
* Date: 2019/02/28 07:38
*/
class EventAttendanceListController extends Controller
{
use ResourceController;

/**
* @var  string
*/
protected $resourceAlias = 'admin.eventattendancelists';

/**
* @var  string
*/
protected $resourceRoutesAlias = 'admin::eventattendancelists';

/**
* Fully qualified class name
*
* @var  string
*/
protected $resourceModel = EventAttendanceList::class;

/**
* @var  string
*/
protected $resourceTitle = 'EventAttendanceList';

/**
* Controller construct
*/
public function __construct(IEventAttendanceListRepository $repository)
{
$this->repository = $repository;
}

}
