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
            'status' => 'required|numeric|between:0,2',
            'user_id' => 'required|exists:users,id',
            'approver_id' => ['required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('jobtitle_id', '>=', MIN_APPROVE_JOB);
                })
            ],
            'approver_at' => 'nullable|date|after_or_equal:start_at',
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
