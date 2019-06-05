<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingMeetingRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'participants' => 'required',
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề',
            'content' => 'nội dung',
            'participants' => 'đối tượng',
            'meeting_room_id' => 'phòng họp',
            'start_time' => 'thời gian bắt đầu',
            'end_time' => 'thời gian kết thúc',
        ];
    }
}
