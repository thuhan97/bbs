<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeedbackRequest extends FormRequest
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
	        'rules' => [
		        'user_id' => ['required', 'integer',
			        Rule::exists('users', 'id')->where(function ($query) {
				        $query->where('status', ACTIVE_STATUS);
			        })
			        ],
		        'type' => 'required|integer|between:0,1',
		        'content' => 'nullable|max:1000',
		        'status' => 'required|integer|between:0,2',
		        'resolver_id' => ['nullable',
			        Rule::exists('users', 'id')->where(function ($query) {
				        $query->where('jobtitle_id', '>=', MIN_APPROVE_JOB)->where('status', ACTIVE_STATUS);
			        })
		        ],
		        'resolver_comment' => 'nullable|max:1000',
		        'resolver_at' => 'nullable|date|after_or_equal:created_at',
	        ]
        ];
    }

	public function attributes()
	{
		return [
			'user_id' => 'Người khiếu nại',
			'type' => 'Vấn đề khiếu nại',
			'content' => 'Nội dung khiếu nại',
			'status' => 'Trạng thái',
			'resolver_id' => 'Người phản hồi',
			'resolver_comment' => 'Ý kiến phản hồi',
			'resolver_at' => 'Phản hồi lúc',
		];
	}
}
