<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventAttendanceRequest extends FormRequest
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
            'event_id' => 'required',
            'status' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'event_id.required' => 'Sự kiện không tồn tại。',
            'status.required' => 'Trái thái không được để trống',
        ];
    }
}
