<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateReportRequest extends FormRequest
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
            'choose_week' => 'required|numeric|min:-1|max:1',
            'status' => 'required|numeric|min:0|max:2',
            'to_ids' => 'required',
            'content' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'choose_week' => 'chọn tuần',
            'to_ids' => 'người nhận',
            'content' => 'nội dung báo cáo',
        ];
    }
}
