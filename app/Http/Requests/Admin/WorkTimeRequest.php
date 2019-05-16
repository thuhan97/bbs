<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckWorkTimeExist;
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
        $datas = \request()->all();
        $rules = [
            'user_id' => 'exists:users,id',
            'work_day' => ['required', 'date', 'before:tomorrow', new CheckWorkTimeExist($datas['id'] ?? 0, $datas['user_id'] ?? 0)],
        ];
        if (isset($datas['start_at']) || empty($datas)) {
            $rules['start_at'] = 'required';
            $rules['end_at'] = 'required';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'work_day' => 'ngày làm việc',
            'start_at' => 'giờ checkin',
            'end_at' => 'giờ checkout',
            'ot_type' => 'loại OT',
            'explanation_type' => 'hình thức',
            'user_id' => 'nhân viên',
            'today' => 'hôm nay',

        ];
    }

    public function messages()
    {
        return [
            'end_at.after' => 'Trường :attribute phải lớn hơn giờ checkin',
            'work_day.before' => 'Vui lòng chọn ngày hôm nay hoặc trước đó.'
        ];
    }
}
