<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApprovedRequest extends FormRequest
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
        dd(111);
        return [
            'id' => 'required|integer',
            'type' => 'required|integer|between:0,4',
            'user_id' => 'required|integer|exists:users,id',
            'work_day' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'work_day' => 'Ngày làm việc',
            'type' => 'Hình thức',
            'user_id' => 'Người làm đơn',
        ];
    }
}
