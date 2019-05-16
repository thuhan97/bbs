<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimePermissionRequest extends FormRequest
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
        $rules = [];
//        $rules['explanation_type'] = 'required';
        $rules['start_at'] = 'required';
        $rules['end_at'] = 'required|after:start_at';
        $rules['work_day'] = 'required|date';
        $rules['reason'] = 'required';
        return $rules;
    }

    public function attributes()
    {
        return [
//            'explanation_type' => 'hình thức',
            'start_at' => 'thời gian bắt đầu',
            'end_at' => 'thời gian kết thúc',
            'work_day' => 'ngày làm việc',
            'reason' => 'lý do',
            'status' => 'trạng thái',
        ];
    }

    public function messages()
    {
        return [
            'end_at.after' => 'Trường :attribute phải lớn hơn giờ bắt đầu',
        ];
    }
}
