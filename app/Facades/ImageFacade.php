<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getRandomString($length = 10, $type = ALPHANUM)
 * @method static string generateRandomString($inputString, $length)
 * @method static string generateActivateToken($maxLength = 128)
 * @method static string removeWhiteSpace($inputString)
 * @method static string getPhoneNumber($inputString)
 * @method static string doubleExplode($word1, $word2, $str)
 * @method static string newLine2Break($inputString)
 * @method static string encode_numericentity($string)
 * @method static string checkContain($string, $keyword)
 * @method static string getThumb($path)
 *
 * @see \App\Helpers\StringHelper
 */
class ImageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'image_helper';
    }
}
