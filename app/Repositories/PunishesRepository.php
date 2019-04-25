<?php 
namespace App\Repositories;

use App\Models\Punishes;
use App\Repositories\Contracts\IPunishesRepository;

/**
* PunishesRepository class
* Author: jvb
* Date: 2019/04/22 08:21
*/
class PunishesRepository extends AbstractRepository implements IPunishesRepository
{
/**
* PunishesModel
*
* @var  string
*/
protected $modelName = Punishes::class;
}
