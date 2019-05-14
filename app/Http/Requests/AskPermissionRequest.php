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
        $rules = [];
        if ($this->request->has('permission_late')) {
            $rules['permission_type'] = [
                'required',
                'integer',
                Rule::in(array_search('Đi muộn',WORK_TIME_TYPE))
            ];
        }

        if ($this->request->has('permission_early')) {
            $rules['permission_type'] = [
                'required',
                'integer',
                Rule::in(array_search('Về Sớm',WORK_TIME_TYPE))
            ];
        }

        if ($this->request->has('permission_ot')) {
            $rules['permission_type'] = [
                'required',
                'integer',
                Rule::in(array_search('Overtime',WORK_TIME_TYPE))
            ];
        }
        $rules['work_day'] = 'required|date';
        $rules['note'] = 'required';
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'Ngày xin phép',
            'permission_type' => 'Hình thức',
        ];
    }
}
