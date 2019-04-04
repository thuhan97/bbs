<?php
/**
 * DiaryListExport
 * @subpackage classExport
 * @author     LuongTuanHung
 */

namespace App\Exports;

use App\Services\Contracts\IEventAttendanceService;

class DowloadExcelEventExport
{
    public $eventId;
    public $filename;

    /**
     * DiaryListExport constructor.
     *
     * @param string $filename
     */
    public function __construct($eventId, $filename)
    {
        $this->eventId = $eventId;
        $this->filename = $filename;
        $this->eventAttendanceService = app()->make(IEventAttendanceService::class);
    }

    /**
     * function get data patient and diary export CSV
     *
     * @create_date 2018/09/18
     * @author HungLT
     * @return array
     */
    public function collection()
    {
        $listUserJoinEvent = $this->eventAttendanceService->getListUserJoinEvent($this->eventId);
        return $listUserJoinEvent;
    }

    /**
     *
     */
    public function exportData()
    {
        $listUserJoinEvent = $this->collection();
        $heighListUserJoinEvent = count($listUserJoinEvent);
        if ($heighListUserJoinEvent > 0) {
            $output = '<table class="table" border="1">
                        <tr>
                            <th>STT</th> 
                            <th>Tên thành viên</th>
                            <th>Mã thành viên</th>
                            <th>Trạng thái</th>
                            <th>Ý kiến cá nhân</th>
                            <th>Ngày đăng kí</th>
                        </tr>
            ';
            $i = 0;
            foreach ($listUserJoinEvent as $listUserJoinEventValue) {
                $status = $listUserJoinEventValue->status == 1 ? STATUS_JOIN_EVENT[1] : STATUS_JOIN_EVENT[0];
                $output .= '
                     <tr>
                        <td>' . $i++ . '</td>
                        <td>' . $listUserJoinEventValue->name . '</td>
                        <td>' . $listUserJoinEventValue->staff_code . '</td>
                        <td>' . $status . '</td>
                        <td>' . $listUserJoinEventValue->content . '</td>
                        <td>' . $listUserJoinEventValue->created_at . '</td>
                     </tr>
                ';
            }
            $output .= '</table>';
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=" . $this->filename . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF";
            echo $output;
        }
    }
}