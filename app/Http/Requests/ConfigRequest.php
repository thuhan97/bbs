<?php

namespace App\Http\Requests;

use App\Facades\AuthAdmin;
use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AuthAdmin::check();
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
            'acronym_name' => 'required|max:255',
//            'late_time_rule_file' => 'nullable|mimes:application/json',
        ];
    }

    public function attributes()
    {
        return [
            'late_time_rule_file' => 'file tính theo giờ đi muộn'
        ];
    }
}
