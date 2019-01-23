<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Admin;

/**
* AdminTransformer class
* Author: jvb
* Date: 2018/09/03 01:52
*/
class AdminTransformer extends Fractal\TransformerAbstract
{
    public function transform(Admin $item)
	{
		return $item->toArray();
	}
}
