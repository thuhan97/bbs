<?php 
namespace App\Repositories;

use App\Models\Rules;
use App\Repositories\Contracts\IRulesRepository;

/**
* RulesRepository class
* Author: jvb
* Date: 2019/04/22 08:21
*/
class RulesRepository extends AbstractRepository implements IRulesRepository
{
/**
* RulesModel
*
* @var  string
*/
protected $modelName = Rules::class;
}
