<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApprovePermissionRequest extends FormRequest
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
        $requestAll = $this->request->all();
        if ($requestAll['permission_type'] == 'other') {
            $rules['id'] = 'required|exists:work_times_explanation,id';
        }elseif ($requestAll['permission_type'] == 'ot') {
            $rules['id'] = 'required|exists:ot_times,id';
        }

        $rules['approve_type'] = 'between:1,2';
        return $rules;
    }
}
