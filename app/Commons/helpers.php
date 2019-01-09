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

if (!function_exists('__l')) {
    /**
     * Encode unicode
     *
     * @param $key
     *
     * @return string
     */
    function __l($key)
    {
        if (\Lang::has("messages.$key")) {
            return __("messages.$key");
        } else {
            \Log::info("messages.$key not exists");
            return $key;
        }
    }
}