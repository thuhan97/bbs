<?php
/**
 * URL Helper
 * User: TrinhNV
 * Date: 8/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

use SimpleXMLElement;

class UrlHelper
{

    /**
     * GET url as xml
     *
     * @param $path
     *
     * @return \SimpleXMLElement
     */
    public static function getXML($path)
    {
        $sXML = self::download_page($path);
        if ($sXML)
            return new SimpleXMLElement($sXML);
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    private static function download_page($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);
        curl_close($ch);
        return $retValue;
    }

}
