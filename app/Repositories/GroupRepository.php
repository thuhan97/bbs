<?php 
namespace App\Repositories;

use App\Models\Group;
use App\Repositories\Contracts\IGroupRepository;

/**
* GroupRepository class
* Author: jvb
* Date: 2019/05/16 14:31
*/
class GroupRepository extends AbstractRepository implements IGroupRepository
{
/**
* GroupModel
*
* @var  string
*/
protected $modelName = Group::class;
}
