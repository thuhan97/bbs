<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Suggestion;

/**
* SuggestionTransformer class
* Author: jvb
* Date: 2019/05/31 10:33
*/
class SuggestionTransformer extends Fractal\TransformerAbstract
{
public function transform(Suggestion $item)
{
return $item->toArray();
}
}
