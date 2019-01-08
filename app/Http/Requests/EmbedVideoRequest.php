<?php

namespace App\Http\Requests;

use App\Rules\IsJapanese;
use Illuminate\Foundation\Http\FormRequest;

class EmbedVideoRequest extends FormRequest
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
            'keyword' => [
                'required',
                'max:500',
//                new IsJapanese()
            ],
            'video_id' => 'required'
        ];
    }
}
