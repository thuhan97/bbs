<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvidedDeviceRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'return_date' => 'nullable|date',
            'approval_manager' => 'nullable',
            'manager_id' => 'nullable|integer',
            'hcns_id' => 'nullable|integer',
            'approval_hcnv' => 'nullable',
            'status' => 'nullable|integer',
            'types_device'=>'required|integer'

        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề',
            'content' => 'nội dung',
            'return_date' => 'ngày trả',
            'approval_manager' => 'ý kiến manager',
            'manager_id' => 'mannager',
            'hcns_id' => 'hành chính nhân sự',
            'approval_hcnv' => 'ý kiến hành chính nhân sự',
            'status' => 'trạng thái'
        ];
    }
}
