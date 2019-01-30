<?php
/**
 * RegulationFileModel class
 * Author: jvb
 * Date: 2019/01/29 08:21
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class RegulationFile extends Model
{
    use  FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'regulation_files';

    protected $fillable = [
        'id',
        'regulation_id',
        'file_path',
        'created_at',
        'updated_at',
    ];
}
