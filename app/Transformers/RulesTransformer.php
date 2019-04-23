<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Rules;

/**
* RulesTransformer class
* Author: jvb
* Date: 2019/04/22 08:21
*/
class RulesTransformer extends Fractal\TransformerAbstract
{
public function transform(Rules $item)
{
return $item->toArray();
}
}
