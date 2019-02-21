<?php

namespace App\Transformers;

use App\Models\Report;
use League\Fractal;

/**
 * ReportTransformer class
 * Author: jvb
 * Date: 2019/01/21 03:42
 */
class ReportTransformer extends Fractal\TransformerAbstract
{
    public function transform(Report $item)
    {
        return $item->toArray();
    }
}
