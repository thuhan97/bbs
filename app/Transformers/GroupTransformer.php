<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Group;

/**
* GroupTransformer class
* Author: jvb
* Date: 2019/05/16 14:31
*/
class GroupTransformer extends Fractal\TransformerAbstract
{
public function transform(Group $item)
{
return $item->toArray();
}
}
