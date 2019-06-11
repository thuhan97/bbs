<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'customer' => 'required|max:255',
            'scale' => 'nullable|numeric|min:1',
            'amount_of_time' => 'nullable|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'technical' => 'nullable|max:255',
            'user_id'=>'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên dự án',
            'customer' => 'khách hàng',
            'start_date' => 'ngày bắt đầu',
            'end_date' => 'ngày kết thúc',
            'scale' => 'quy mô dự án',
            'amount_of_time' => 'thời gian thực hiện',
            'user_id' => 'người tham gia',
        ];
    }
}
