<?php
/**
 * Created by PhpStorm.
 * User: TrinhNV
 * Date: 4/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

class StringHelper
{
    /**
     * Generate and return a random characters string
     *
     * Useful for generating passwords or hashes.
     *
     * The default string returned is 10 alphanumeric characters string.
     *
     * The type of string returned can be changed with the "type" parameter.
     * Four types are: alpha, alphanum, num, nozero.
     *
     * @param   integer $length Length of the string to be generated, Default: 10 characters long.
     * @param   string  $type   Type of random string.  alpha, alphanum, num, nozero.
     *
     * @return  string
     */
    public function getRandomString($length = 10, $type = ALPHANUM)
    {
        $seedings = array();
        $seedings['alpha'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $seedings[ALPHANUM] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $seedings['num'] = '0123456789';
        $seedings['nozero'] = '123456789';
        if (!isset($seedings[$type])) {
            $type = ALPHANUM;
        }

        $pool = $seedings[$type];

        return $this->generateRandomString($pool, $length);
    }

    /**
     * @param $inputString
     * @param $length
     *
     * @return string
     */
    public function generateRandomString($inputString, $length)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($inputString, mt_rand(0, strlen($inputString) - 1), 1);
        }
        return $str;
    }

    /**
     * @param int $maxLength
     *
     * @return string
     */
    public function generateActivateToken($maxLength = 128)
    {
        $length = 0;
        $result = '';
        while ($length < $maxLength) {
            $buffLength = rand(20, 50);
            if ($length + $buffLength > $maxLength) {
                $buffLength = $maxLength - $length;
            }

            $result .= $this->getRandomString($buffLength) . '_';
            $length += $buffLength + 1;
        }

        return $result;
    }

    /**
     * @param $inputString
     *
     * @return mixed
     */
    public static function removeWhiteSpace($inputString)
    {
        if ($inputString) {
            return preg_replace('/[ 　]/u', '', $inputString);
        }
        return $inputString;
    }

    /**
     * @param $inputString
     *
     * @return mixed
     */
    public static function getPhoneNumber($inputString)
    {
        if ($inputString) {
            return preg_replace('/[()-]+/', '', $inputString);
        }
        return $inputString;
    }

    /**
     * @param $word1
     * @param $word2
     * @param $str
     *
     * @return array
     */
    public static function doubleExplode($word1, $word2, $str)
    {
        $return = array();

        $array = explode($word1, $str);

        foreach ($array as $value) {
            $return = array_merge($return, explode($word2, $value));
        }
        return $return;
    }

    /**
     * @param $inputString
     *
     * @return string
     */
    public static function newLine2Break($inputString)
    {
        if (!$inputString) {
            return '';
        }
        return nl2br($inputString);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public static function encode_numericentity($string)
    {
        $convmap = array(0x80, 0xff, 0, 0xff);
        return mb_encode_numericentity($string, $convmap, "ISO-8859-1");
    }

    /**
     * @param $string
     * @param $keyword
     *
     * @return bool
     */
    public static function checkContain($string, $keyword)
    {
        return str_contains($string, $keyword);
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    public static function getThumb($path)
    {
        $str_to_insert = '/thumbs';
        $oldstr = $path;
        $pos = strrpos($path, "/");

        return substr_replace($oldstr, $str_to_insert, $pos, 0);
    }

}
