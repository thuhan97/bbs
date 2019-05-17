<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AskPermissionRequest extends FormRequest
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
        $requestAll = $this->request->all();

        $rules = [];
        if ($this->request->has('permission_late')) {
            $rules['permission_type'] = [
                'required',
                'integer',
                Rule::in(array_search('Đi muộn', WORK_TIME_TYPE))
            ];
            $rules['work_day'] = 'required|date';
            $rules['note'] = 'required';
        }

        if ($this->request->has('permission_early')) {

            $rules['permission_type'] = [
                'required',
                'integer',
                Rule::in(array_search('Về Sớm', WORK_TIME_TYPE))
            ];
            $rules['work_day'] = 'required|date';
            $rules['note'] = 'required';
        }

        if ($this->request->has('permission_ot')) {

            $rules['permission_type'] = [
                'required',
                Rule::in(array_search('Overtime', WORK_TIME_TYPE))
            ];
            $rules['ot_type'] = 'required|between:1,2';
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required|after:start_at';
            $rules['work_day'] = 'required|date';
            $rules['note'] = 'required';
        }

        if ($requestAll['ot_type'] == array_search('Đi muộn', WORK_TIME_TYPE)) {
            $rules['project_name'] = 'required|exists:projects,id';

        }

        if ($this->has('work_time_explanation_id')) {
            $rules['work_time_explanation_id'] = 'required|integer';
            $rules['reason_reject'] = 'required';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'Ngày xin phép',
            'permission_type' => 'Hình thức',
            'work_time_explanation_id' => 'id',
            'reason_reject' => 'lý do',
            'ot_type' => 'hình thức',
            'project_name' => 'dự án',
            'start_at' => 'thời gian bắt đầu',
            'end_at' => 'thời gian kết thúc',
            'work_day' => 'ngày làm việc',
            'note' => 'lý do',
            'status' => 'trạng thái',
        ];
    }
}
