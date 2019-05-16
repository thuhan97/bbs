<?php

namespace App\Rules;

use App\Models\WorkTime;
use Illuminate\Contracts\Validation\Rule;

class CheckWorkTimeExist implements Rule
{
    private $id;
    private $user_id;

    /**
     * Create a new rule instance.
     *
     * @param $id
     * @param $user_id
     */
    public function __construct($id, $user_id)
    {
        //
        $this->id = $id;
        $this->user_id = $user_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $model = WorkTime::where('user_id', $this->user_id)->where('work_day', $value);
        if ($this->id) {
            return !$model->where('id', '!=', $this->id)->exists();

        } else {
            return !$model->exists();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Đã có dữ liệu chấm công của nhân viên trong ngày được chọn.';
    }
}
