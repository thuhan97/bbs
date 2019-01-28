<?php

namespace App\Http\Requests\Admin;

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
            'title' => 'required|max:255',
            'reason' => 'required|max:1000',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'status' => 'required|numeric|min:0|max:1',
            'user_id' => 'required|exists:users,id',
            'approver_id' => ['nullable',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('jobtitle_id', '>=', MIN_APPROVE_JOB);
                })
            ],
            'approver_at' => 'nullable|date|after_or_equal:start_at',
            'number_off' => array('regex:/^\d(\.[05])?$/', 'min:1', 'max:10'),
            'approve_comment' => 'nullable|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề',
            'reason' => 'lý do nghỉ',
            'start_at' => 'ngày bắt đầu nghỉ',
            'end_at' => 'nghỉ đến ngày',
            'user_id' => 'người đề xuất',
            'approver_id' => 'người duyệt',
            'number_off' => 'số ngày nghỉ được tính',
            'approve_comment' => 'người duyệt',
        ];
    }

    public function messages()
    {
        return [
//            'number_off.regex' => ''
        ];
    }
}
