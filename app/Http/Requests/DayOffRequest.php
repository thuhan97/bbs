<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DayOffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        	'user_id'=>['nullable','integer',
		        Rule::exists('users', 'id')->where(function ($query) {
			        $query->where('status', ACTIVE_STATUS);
		        })
	        ],
	        'approver_id' => ['nullable', 'integer',
		        Rule::exists('users', 'id')->where(function ($query) {
			        $query->where('jobtitle_id', '>=', MIN_APPROVE_JOB)->where('status', ACTIVE_STATUS);
		        })
	        ],
	        'title' => 'string|nullable|max:255|min:3',
	        'reason' => 'string|nullable|max:1000|min:3',
	        'start_at' => 'date',
	        'end_at' => 'date|after_or_equal:start_at',
	        'status' => 'nullable|integer|between:0,1',
	        'approve_comment' => 'nullable|max:1000',
	        'approver_at' => 'nullable|date|after_or_equal:created_at',
	        'number_off' => array('regex:/^\d(\.[05])?$/', 'min:1', 'max:10', 'nullable'),
        ];
    }
}
