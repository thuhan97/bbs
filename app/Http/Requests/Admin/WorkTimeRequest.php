<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeRequest extends FormRequest
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
        $datas = \request()->all();
        $rules = [];
        if (isset($datas['start_at']) || empty($datas)) {
            $rules['type'] = 'required|integer';
            $rules['work_day'] = 'required|date';
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required';
        } else {
            $rules['work_day'] = 'required|date';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'work_day' => 'ngày làm việc',
            'start_at' => 'giờ checkin',
            'end_at' => 'giờ checkout',
            'ot_type' => 'loại OT',
            'explanation_type' => 'hình thức',
        ];
    }

    public function messages()
    {
        return [
            'end_at.after' => 'Trường :attribute phải lớn hơn giờ checkin'
        ];
    }
}
