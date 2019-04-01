<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;


class Meeting extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;
    protected $table='meetings';
    protected $fillable= [
    	'name',
    	'area',
    	'seats',
    	'equipment',
    	'other',
	];
	public function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%');
    }
}
