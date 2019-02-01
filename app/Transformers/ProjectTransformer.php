<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Project;

/**
* ProjectTransformer class
* Author: jvb
* Date: 2019/01/31 05:00
*/
class ProjectTransformer extends Fractal\TransformerAbstract
{
    public function transform(Project $item)
	{
		return $item->toArray();
	}
}
