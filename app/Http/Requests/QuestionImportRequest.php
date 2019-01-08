<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionImportRequest extends FormRequest
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
            'question_set_id' => 'required|exists:question_sets,id',
            'import_file' => 'required|max:10000',
            'delete_old_data' => 'nullable|numeric|max:1',
        ];
    }
}
