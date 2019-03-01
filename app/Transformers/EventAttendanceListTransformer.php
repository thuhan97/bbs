<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\EventAttendanceList;

/**
* EventAttendanceListTransformer class
* Author: jvb
* Date: 2019/02/28 07:38
*/
class EventAttendanceListTransformer extends Fractal\TransformerAbstract
{
public function transform(EventAttendanceList $item)
{
return $item->toArray();
}
}
