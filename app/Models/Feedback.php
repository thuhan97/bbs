<?php
/**
 * FeedbackModel class
 * Author: jvb
 * Date: 2019/01/30 02:59
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
	use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

	const FEEDBACK_TYPE = [
		'absence' => 0,
		'attendance' => 1
	];

	const FEEDBACK_STATUS = [
		'pending' => 0,
		'accept' => 1,
		'decline' => 2
	];

	protected $table = 'feedbacks';

	protected $primaryKey = 'id';

	protected $fillable = [
		'user_id',
		'type',
		'content',
		'status',
		'resolver_id',
		'resolver_comment',
		'resolver_at',
		'created_at',
		'updated_at',
	];


}
