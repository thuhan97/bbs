<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionSetCreateRequest extends FormRequest
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
        $data = $this->request->all();

        $rules = [
            'level_id' => 'required|exists:levels,id',
            'topic_id' => 'required|exists:topics,id',
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|max:1000',
            'total_question' => 'required|numeric',
            'potato' => 'required|numeric|min:0',
            'max_pick_potato' => 'required|numeric|min:0',
            'min_pick_potato' => 'required|numeric|min:0',
            'number_to_pass' => 'required|numeric',
            'total_time' => 'required|numeric',
        ];

        if (isset($data['potato'])) {
            $rules['max_pick_potato'] .= '|max:' . $data['potato'];
        }

        if (isset($data['max_pick_potato'])) {
            $rules['min_pick_potato'] .= '|max:' . $data['max_pick_potato'];
        }

        return $rules;
    }
}
