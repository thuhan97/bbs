<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CheckInImportRequest extends FormRequest
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
            'year' => 'required|date|date_format:Y',
            'month' => 'required|date|date_format:m',
            'import_file' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'import_file' => 'bảng chấm công',
        ];
    }
}
