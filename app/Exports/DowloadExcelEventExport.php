<?php
/**
 * DiaryListExport
 * @subpackage classExport
 * @author     LuongTuanHung
 */

namespace App\Exports;

use App\Services\Contracts\IEventAttendanceService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DowloadExcelEventExport implements FromCollection, WithHeadings
{
    public $eventId;

    /**
     * DiaryListExport constructor.
     *
     * @param string $filename
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
        $this->eventAttendanceService = app()->make(IEventAttendanceService::class);
    }

    /**
     * function get data patient and diary export CSV
     *
     * @create_date 2018/09/18
     * @author HungLT
     * @return array
     */
    public function Collection()
    {
        $listUserJoinEvent = $this->eventAttendanceService->getListUserJoinEvent($this->eventId);
        $results = [];
        $i = 1;
        foreach ($listUserJoinEvent as $listUserJoinEventValue) {
            $item = $this->makeRow($listUserJoinEventValue, $i++);
            $results[] = $item;
        }
        return collect($results);
    }

    /**
     * Function Heading
     *
     * @create_date: 2018/08/27
     * @author     : Tiennm
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'Tên thành viên ',
            'Mã nhân viên',
            'Trạng thái',
            'Ý kiến cá nhân',
            'Ngày đăng kí'
        ];
    }

    /**
     * Function Make Row data
     *
     * @create_date: 2018/08/27
     * @author     : Tiennm
     * @return array
     */
    public function makeRow($listUserJoinEventValue, $i)
    {
        $status = $listUserJoinEventValue->status == 1 ? STATUS_JOIN_EVENT[1] : STATUS_JOIN_EVENT[0];
        return [
            'stt' => $i++,
            'name' => $listUserJoinEventValue->name,
            'staff_code' => $listUserJoinEventValue->staff_code,
            'status' => $status,
            'content' => $listUserJoinEventValue->content,
            'created_at' => $listUserJoinEventValue->created_at,
        ];
    }

}