<?php 
namespace App\Repositories;

use App\Models\Meeting;
use App\Repositories\Contracts\IMeetingRepository;

/**
* DeviceRepository class
* Author: jvb
* Date: 2019/03/11 06:46
*/
class MeetingRepository extends AbstractRepository implements IMeetingRepository
{
/**
* DeviceModel
*
* @var  string
*/
protected $modelName = Meeting::class;
}
