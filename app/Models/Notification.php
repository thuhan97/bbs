<?php
/**
 * NotificationModel class
 * Author: jvb
 * Date: 2019/05/29 15:13
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Webpatser\Uuid\Uuid;

class Notification extends Model
{
    use FillableFields, OrderableTrait, SearchLikeTrait;

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'user_id',
        'logo_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'sender_id',
        'title',
        'content',
        'data',
        'read_at',
        'created_at',
        'updated_at',
    ];

    public static function generateUID()
    {
        return Uuid::generate()->string;
    }

    public function getIsReadAttribute($key)
    {
        return $this->read_at !== null ? 1 : 0;
    }
}
