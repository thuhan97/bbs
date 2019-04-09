<?php

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

if (!function_exists('number_collapse')) {
    /**
     * Collapse number
     *
     * @param integer $number
     * @param string  $separator
     *
     * @return string
     */
    function number_collapse($number, $separator = '')
    {
        $result = '';
        if ($number && is_numeric($number)) {
            if ($number > 1000000000) {
                $result = floor($number / 1000000000) . 'b';
                if ($number % 1000000000 != 0) {
                    $result .= $separator . number_collapse($number % 1000000000, ',');
                }
            } else if ($number > 1000000) {
                $result = floor($number / 1000000) . 'm';
                if ($number % 1000000 != 0 && empty($separator)) {
                    $result .= $separator . number_collapse($number % 1000000, ',');
                }
            } else if ($number > 1000) {
                $result = floor($number / 1000) . 'k';
                if ($number % 1000 != 0 && empty($separator)) {
                    $result .= $separator . number_collapse($number % 1000, ',');
                }
            } else {
                if (empty($separator))
                    $result = $number;
            }
        }
        return $result;
    }
}

if (!function_exists('cdn_asset')) {
    /**
     * Generate a cdn asset path.
     *
     * @param string $path
     *
     * @return string
     */
    function cdn_asset($path)
    {
        return \App\Utils::cdnAsset($path);
    }
}

if (!function_exists('trustedproxy_config')) {
    /**
     * Get Trusted Proxy value
     *
     * @param string $key
     * @param string $env_value
     *
     * @return mixed
     */
    function trustedproxy_config($key, $env_value)
    {
        if ($key === 'proxies') {
            if ($env_value === '*' || $env_value === '**') {
                return $env_value;
            }

            return $env_value ? explode(',', $env_value) : null;
        } elseif ($key === 'headers') {
            if ($env_value === 'HEADER_X_FORWARDED_AWS_ELB') {
                return Request::HEADER_X_FORWARDED_AWS_ELB;
            } elseif ($env_value === 'HEADER_FORWARDED') {
                return Request::HEADER_FORWARDED;
            }

            return Request::HEADER_X_FORWARDED_ALL;
        }

        return null;
    }
}

if (!function_exists('redirect_back_field')) {
    /**
     * Generate a redirect back url form field.
     *
     * @return \Illuminate\Support\HtmlString
     */
    function redirect_back_field()
    {
        return new HtmlString('<input type="hidden" name="_redirect_back" value="' . old('_redirect_back', back()->getTargetUrl()) . '">');
    }
}

if (!function_exists('redirect_back_to')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null $callbackUrl
     * @param  int         $status
     * @param  array       $headers
     * @param  bool        $secure
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect_back_to($callbackUrl = null, $status = 302, $headers = [], $secure = null)
    {
        $to = request()->input('_redirect_back', back()->getTargetUrl());
        if ($callbackUrl) {
            if (!starts_with($to, $callbackUrl)) {
                $to = $callbackUrl;
            }
        }

        return redirect($to, $status, $headers, $secure);
    }
}

if (!function_exists('lfm_thumbnail')) {
    /**
     * Get image thumbnail LFM
     *
     * @param $imagePath
     *
     * @return string
     */
    function lfm_thumbnail($imagePath)
    {
        $img_thumb = explode('/', $imagePath);
        $directory = dirname($imagePath);

        return $directory . '/thumbs/' . end($img_thumb);
    }
}

if (!function_exists('unicode_encode')) {
    /**
     * Encode unicode
     *
     * @param $str
     *
     * @return string
     */
    function unicode_encode($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $str);
    }
}
if (!function_exists('get_day_of_week')) {

    function get_day_of_week()
    {
        return [
            "1" => "Thứ 2",
            "2" => "Thứ 3",
            "3" => "Thứ 4",
            "4" => "Thứ 5",
            "5" => "Thứ 6",
            "6" => "Thứ 7",
            "7" => "Chủ nhật",
        ];
    }
}
if (!function_exists('get_week_number')) {
    /**
     * Get week number
     *
     * @param $ddate
     *
     * @return string
     */
    function get_week_number($ddate = null)
    {
        if ($ddate !== null)
            $ddate = date(DATE_FORMAT);
        $date = new DateTime($ddate);

        return $date->format("W");
    }
}
if (!function_exists('get_week_info')) {
    /**
     * 0: this week, -1: next week; 1: last week
     *
     * @param $type
     * @param $week_number
     *
     * @return string
     */
    function get_week_info($type = 0, &$week_number = null)
    {
        [$firstDay, $lastDay] = get_first_last_day_in_week($type, $day);
        $week_number = get_week_number($day);
        $year = date('Y');
        return "$week_number-$year [$firstDay - $lastDay]";
    }
}

if (!function_exists('get_first_last_day_in_week')) {
    /**
     * 0: this week, -1: next week; 1: last week
     *
     * @param $type
     * @param $day
     *
     * @return array
     */
    function get_first_last_day_in_week($type = 0, &$day = null)
    {
        switch ($type) {
            case 1;
                $day = date(DATE_FORMAT, strtotime('-7 days'));
                break;
            case -1;
                $day = date(DATE_FORMAT, strtotime('+7 days'));
                break;
            default:
                $day = date(DATE_FORMAT);
                break;
        }

        $firstDay = date(DATE_MONTH_REPORT, strtotime("monday this week", strtotime($day)));
        $lastDay = date(DATE_MONTH_REPORT, strtotime("saturday this week", strtotime($day)));

        return [$firstDay, $lastDay];
    }
}

if (!function_exists('getMonthFormWeek')) {
    function getMonthFormWeek($week, $year = null)
    {
        if (!$year) $year = date('Y');
        $weekDays = getStartAndEndDate($week, $year);
        $week_start = $weekDays['week_start'];
        return explode('-', $week_start)[1];
    }
}

if (!function_exists('getStartAndEndDate')) {
    function getStartAndEndDate($week, $year)
    {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');

        return $ret;
    }
}
if (!function_exists('get_years')) {
    /**
     * Encode unicode
     *
     * @param integer $num
     * @param string  $prefix
     * @param bool    $isDesc
     *
     * @return string
     *
     */
    function get_years($num = 5, $prefix = '', $isDesc = true)
    {
        $result = [];
        $currentYear = date('Y');
        $minYear = $currentYear - $num;
        $start = $isDesc ? $currentYear : $minYear;
        $step = $isDesc ? -1 : 1;

        while ($start > $minYear && $start <= $currentYear) {
            $result[$start] = $prefix . $start;
            $start = $start + $step;
        }

        return ['' => 'Chọn năm'] + $result;
    }
}

if (!function_exists('get_months')) {
    /**
     * Get months
     *
     * @param string $prefix
     * @param bool   $isDesc
     *
     * @return string
     *
     */
    function get_months($prefix = '', $isDesc = false)
    {
        $result = [];
        $start = $isDesc ? 12 : 1;
        $step = $isDesc ? -1 : 1;

        while ($start >= 1 && $start <= 12) {
            $result[$start] = $prefix . $start;
            $start = $start + $step;
        }

        return ['' => 'Chọn tháng'] + $result;
    }
}

if (!function_exists('__l')) {
    /**
     * Encode unicode
     *
     * @param $key
     * @param $attr
     *
     * @return string
     */
    function __l($key, $attr = [])
    {
        if (\Lang::has("messages.$key")) {
            return __("messages.$key", $attr);
        } else {
            \Log::info("messages.$key not exists");
            return $key;
        }
    }
}

if (!function_exists('__admin_sortable')) {
    /**
     * Echo sortable url
     *
     * @param $field
     *
     * @return string
     */
    function __admin_sortable($field)
    {
        echo '<a href="' . \Request::fullUrlWithQuery(['sort' => $field, 'is_desc' => !request('is_desc', false)]) . '"class="ic-ca">';
        if (request('sort') == $field && request('is_desc') == 1) {
            echo '<span class="dropup"><span class="caret"></span></span>';
        } else {
            echo '<span class="caret"></span>';
        }
        echo '</a>';
    }
}
