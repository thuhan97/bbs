<?php
namespace App\Helpers;


class FloatAndIntHelper
{
    public static function checkNumber($number)
    {
        $explode=explode('.',$number);
        if ($explode[1] > 0){
            return $number;
        }else{
            return $explode[0];
        }
    }
}