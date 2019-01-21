<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Report;

/**
* ReportTransformer class
* Author: trinhnv
* Date: 2019/01/21 03:42
*/
class ReportTransformer extends Fractal\TransformerAbstract
{
    public function transform(Report $item)
	{
		return $item->toArray();
	}
}
