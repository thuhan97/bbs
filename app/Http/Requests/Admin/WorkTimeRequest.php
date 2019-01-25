<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeRequest extends FormRequest
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
            'start_at' => 'required|date|date_format:h:i',
            'end_at' => 'required|date|date_format:h:i',
            'work_day' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'work_day' => 'ngày làm việc',
            'start_at' => 'giờ checkin',
            'end_at' => 'giờ checkout',
        ];
    }

}
