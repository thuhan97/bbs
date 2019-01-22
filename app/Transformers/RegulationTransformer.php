<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Regulation;

/**
* RegulationTransformer class
* Author: jvb
* Date: 2019/01/11 09:23
*/
class RegulationTransformer extends Fractal\TransformerAbstract
{
    public function transform(Regulation $item)
	{
		return $item->toArray();
	}
}
