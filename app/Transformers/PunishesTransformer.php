<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Punishes;

/**
* PunishesTransformer class
* Author: jvb
* Date: 2019/04/22 08:21
*/
class PunishesTransformer extends Fractal\TransformerAbstract
{
public function transform(Punishes $item)
{
return $item->toArray();
}
}
