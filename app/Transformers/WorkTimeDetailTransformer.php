<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\WorkTimeDetail;

/**
* WorkTimeDetailTransformer class
* Author: jvb
* Date: 2019/01/22 10:50
*/
class WorkTimeDetailTransformer extends Fractal\TransformerAbstract
{
    public function transform(WorkTimeDetail $item)
	{
		return $item->toArray();
	}
}
