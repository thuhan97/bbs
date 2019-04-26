<?php
/**
 * ShareModel class
 * Author: jvb
 * Date: 2019/01/22 10:50
 */

namespace App\Models;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'id',
        'creator_id',
        'share_id',
        'parent_comment_id',
        'content',
        'created_at',
    ];
}
