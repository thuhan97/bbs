<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Feedback;

/**
* FeedbackTransformer class
* Author: jvb
* Date: 2019/01/30 02:59
*/
class FeedbackTransformer extends Fractal\TransformerAbstract
{
    public function transform(Feedback $item)
	{
		return $item->toArray();
	}
}
