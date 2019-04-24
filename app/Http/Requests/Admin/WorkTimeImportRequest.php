<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeImportRequest extends FormRequest
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
        \Validator::extend('same_month', function ($attribute, $value, $parameters, $validator) {
            $startDate = $this->request->get($parameters[0]);
            return get_month($startDate) == get_month($value);
        });
        return [
            'year' => 'required',
            'month' => 'required_without:start_date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|required_with:start_date|date|after:start_date|same_month:start_date',
            'import_file' => 'required',
        ];
    }

    public function messages()
    {
        return [
           'same_month' => 'Vui lòng chọn dữ liệu trong cùng một tháng.'
        ];
    }

    public function attributes()
    {
        return [
            'import_file' => 'bảng chấm công',
            'start_date' => 'từ ngày',
            'end_date' => 'đến ngày',
        ];
    }
}
