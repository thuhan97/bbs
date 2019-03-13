<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\EventAttendance;

/**
* EventAttendanceListTransformer class
* Author: jvb
* Date: 2019/03/11 09:35
*/
class EventAttendanceTransformer extends Fractal\TransformerAbstract
{
public function transform(EventAttendance $item)
{
return $item->toArray();
}
}
