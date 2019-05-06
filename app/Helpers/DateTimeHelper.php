<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Validation\ValidationException;

class DateTimeHelper
{
    public static function prettyTime($seconds)
    {
        if ($seconds) {

            $hrs = floor($seconds / 3600);
            $mins = floor(($seconds % 3600) / 60);
            $secs = floor($seconds % 60);
            $ret = "";

            if ($hrs > 0) {
                $ret .= $hrs . "h" . ($mins < 10 ? "0" : "");
            }
            if ($mins > 0) {
                $ret .= $mins . "m" . ($secs < 10 ? "0" : "");
            }
            $ret .= $secs . "s";

            return $ret;
        }
    }

    public static function getDateOfNextMonth($date, $add = 1)
    {
        $date = strtotime($date);
        $day = date('d', $date);
        $month = strtotime('first day of this month', $date);
        $month = strtotime('+' . $add . ' month', $month);
        if ($day == 31 || ($day >= 28 && date('m', $date) == 2)) {
            $day = date('d', strtotime('last day of this month', $month));
        } else if ($day >= 29 && date('m', $month) == 2) {
            $day = (date('Y', $month) % 4 == 0) ? 29 : 28;
        }

        return date('Y-m-', $month) . $day;
    }

    public static function getLastDateOnNextMonth()
    {
        return date('Y-m-t', strtotime('next month'));
    }

    public function checkMonthDayWithoutZero($month, $day)
    {
        $format = 'Y-n-j';

        $dateStr = date("Y") . '-' . $month . '-' . $day;
        $d = DateTime::createFromFormat($format, $dateStr);
        if (!$d || $d->format($format) != $dateStr) {
            return false;    // invalid
        }

        return true;
    }

    public function validateMonthDayWithoutZero($month, $day, $message = '')
    {
        $valid = $this->checkMonthDayWithoutZero($month, $day);

        if (!$valid) {
            $message = empty($message) ? 'Day is invalid' : $message;
            $v = \Validator::make(
                ['day' => -1],
                ['day' => 'in:1,31'],
                ['day.in' => $message]
            );
            throw new ValidationException($v);
        }

        return true;
    }

    // string input with format: 'Y-m-d H:i:s'
    public static function formatDate($value)
    {
        if (empty($value)) {
            return '';
        }

        return date('Y-m-d', strtotime($value));
    }

    /**
     * @param $startAt
     * @param $endAt
     *
     * @return int
     */
    public static function getDayOffNumbers($startAt, $endAt)
    {
        return 0;
    }


    public static function workTime($id, $day)
    {
        $time = \App\Models\WorkTime::where('user_id', $id)->whereDate('work_day', '=', $day)->first();
        $startAt = $time->start_at ?? '';
        $endAt = $time->end_at ?? '';
        return $workTime = [
            $startAt, $endAt
        ];
    }

}
