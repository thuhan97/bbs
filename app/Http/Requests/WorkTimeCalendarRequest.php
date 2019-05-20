<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeCalendarRequest extends FormRequest
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
        if ($this->request->has('checkOtType') && $requestAll['checkOtType'] == 2) {
            $rules['ot_type'] = 'required|between:1,2';
            $rules['project_id'] = 'required|exists:projects,id';
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required|after:start_at';
        } elseif ($this->request->has('explanation_type')) {
            $rules['explanation_type'] = 'required|between:1,2';
        } elseif ($this->request->has('wt_ask_permission') && $requestAll['wt_ask_permission'] == null) {
            $rules['wt_ask_permission'] = 'required';
        } elseif ($this->request->has('wt_ask_permission_ot') && $requestAll['wt_ask_permission_ot'] == null) {
            $rules['ot_type'] = 'required|between:1,2';
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required|after:start_at';
        }
        if ($this->request->has('wt_ask_permission_ot_project') && $requestAll['wt_ask_permission_ot_project'] == 'true') {
            $rules['ot_type'] = 'required|between:1,2';
            $rules['project_id'] = 'required|exists:projects,id';
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required|after:start_at';
        }

        $rules['work_day'] = 'required|date';
        $rules['reason'] = 'required';
        return $rules;
    }


    public function attributes()
    {
        return [
            'ot_type' => 'hình thức',
            'wt_ask_permission' => 'hình thức',
            'project_id' => 'dự án',
            'start_at' => 'thời gian bắt đầu',
            'end_at' => 'thời gian kết thúc',
            'work_day' => 'ngày làm việc',
            'reason' => 'lý do',
            'status' => 'trạng thái',
        ];
    }

    public function messages()
    {
        return [
            'end_at.after' => 'Trường :attribute phải lớn hơn giờ bắt đầu',
        ];
    }
}
