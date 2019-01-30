<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'address' => 'required',
            'current_address' => 'required',
            'school'=>'required',
            'gmail'=>'email',
            'avatar'=>'mimes:jpeg,jpg,png,gif|max:10000'

        ];
    }

    public function attributes()
    {
        return [
            'address' => 'Địa chỉ',
            'current_address' => 'Địa chỉ hiện tại',
            'school'=>'Học vấn',
            'gmail'=>'Gmail',
        ];
    }
}
