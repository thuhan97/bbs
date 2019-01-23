<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\DayOff;

/**
* DayOffTransformer class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class DayOffTransformer extends Fractal\TransformerAbstract
{
    public function transform(DayOff $item)
	{
		return $item->toArray();
	}
}
