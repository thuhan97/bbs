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
        if ($this->request->has('explanation_ot_type')){
            $rules['explanation_ot_type'] = 'required|integer|between:1,2';
        }
        $rules['explanation_type'] = 'required|integer|between:1,4';
        $rules['work_day'] = 'required|date';
        $rules['reason'] = 'required';
        return $rules;
    }

    public function attributes()
    {
        return [
            'explanation_ot_type' => 'hình thức ot',
            'explanation_type' => 'hình thức',
            'work_day' => 'ngày làm việc',
            'reason' => 'lý do',
            'status' => 'trạng thái',
        ];
    }

    public function messages()
    {
        return [
            'end_at.after' => 'Trường :attribute phải lớn hơn giờ checkin',
        ];
    }
}
