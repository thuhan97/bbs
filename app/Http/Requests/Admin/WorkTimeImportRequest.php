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
        return [
            'year' => 'required',
            'month' => 'required_without:start_date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|required_with:start_date|date|after:start_date',
            'import_file' => 'required',
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
