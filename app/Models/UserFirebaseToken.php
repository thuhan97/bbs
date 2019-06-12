<?php
/**
 * UserFirebaseTokenModel class
 * Author: jvb
 * Date: 2019/06/12 09:11
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;

class UserFirebaseToken extends Model
{
    use  FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'user_firebase_tokens';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'token',
        'userAgent',
        'ip',
        'is_disabled',
        'push_at',
    ];
}
