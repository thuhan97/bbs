<?php

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MeetingRoom extends Model
{
    use Notifiable, SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'meeting_rooms';

    protected $fillable = [
        'name',
        'seats',
        'description',
        'color',
        'other',
    ];

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('seats', 'like', '%' . $searchTerm . '%')
            ->orWhere('description', 'like', '%' . $searchTerm . '%')
            ->orWhere('other', 'like', '%' . $searchTerm . '%');
    }
}
