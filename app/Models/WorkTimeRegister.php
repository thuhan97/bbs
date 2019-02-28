<?php

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\Model;

class WorkTimeRegister extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'work_time_registers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'day',
        'start_at',
        'end_at',
        'select_type'
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('user_id', 'like', '%' . $searchTerm . '%')
            ->orwhere('day', 'like', '%' . $searchTerm . '%');
    }
}
