<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDayOffRequest extends FormRequest
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
        $rules= [
            'approver_id' => ['required', 'integer',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('jobtitle_id', '>=', MIN_APPROVE_JOB)->where('status', ACTIVE_STATUS);
                })
            ],
            'title' => 'required|integer',
            'reason' => 'required|max:1000|min:3',
            'start_at' => 'required|after_or_equal:today',
            'end_at' => 'required|after_or_equal:start_at',
            'status' => 'nullable|integer|between:0,1',
            'number_off' => 'required|numeric',

        ];
        if ($this->id) {
            $rules['start_at'] = "required|date";
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'start_at.after_or_equal' => 'Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại.',
            'end_at.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.'
        ];
    }
    public function attributes()
    {
        return [
            'title' => 'mục đích',
            'reason' => 'nội dung xin nghỉ',
            'start_at' => 'ngày bắt đầu',
            'end_at' => 'ngày kết thúc',
            'approver_id' => 'người phê duyệt',
            'number_off'=>'số ngày dự kiến'
        ];
    }
}
