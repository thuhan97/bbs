<?php

namespace App\Http\Requests;

use App\Facades\AuthAdmin;
use Illuminate\Foundation\Http\FormRequest;

class SendBroadcastRequest extends FormRequest
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
            'users_id' => 'array',
            'title' => 'required|max:100',
            'content' => 'required|max:255',
            'url' => 'nullable|url',
        ];
    }
}
