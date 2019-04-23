<?php

namespace App\Http\Requests;

use App\Facades\AuthAdmin;
use Illuminate\Foundation\Http\FormRequest;

class PunishRequest extends FormRequest
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
        $request = \request();
        $isEdit = $request->id > 0;
        return [
            'rule_id' => ($isEdit ? 'nullable' : 'required') . ($request->rule_id == 0 ? '' : '|exists:rules,id'),
            'user_id' => ($isEdit ? 'nullable' : 'required') . '|exists:users,id',
            'infringe_date' => 'required|date',
            'detail' => 'max:191',
        ];
    }

    public function attributes()
    {
        return [
            'rule_id' => 'tên vi phạm',
            'user_id' => 'nhân viên',
            'infringe_date' => 'ngày vi phạm',
            'detail' => 'chứng cớ',
        ];
    }
}
