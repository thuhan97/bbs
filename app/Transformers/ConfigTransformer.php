<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Config;

/**
* ConfigTransformer class
* Author: trinhnv
* Date: 2018/11/15 16:31
*/
class ConfigTransformer extends Fractal\TransformerAbstract
{
    public function transform(Config $item)
	{
		return $item->toArray();
	}
}
