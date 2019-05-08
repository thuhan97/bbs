<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AskPermissionRequest extends FormRequest
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
            'work_day' => 'required|date',
            'type' => 'required|between:1,4|integer',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Ngày xin phép',
            'type' => 'Hình thức',
        ];
    }
}
