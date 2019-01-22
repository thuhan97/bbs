<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\OverTime;

/**
* OverTimeTransformer class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class OverTimeTransformer extends Fractal\TransformerAbstract
{
    public function transform(OverTime $item)
	{
		return $item->toArray();
	}
}
