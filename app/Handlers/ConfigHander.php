<?php
/**
 * Created by PhpStorm.
 * User: batri
 * Date: 10/22/2018
 * Time: 12:18 AM
 */

namespace App\Handlers;

use App\Facades\AuthAdmin;

class ConfigHander
{
    public function userField()
    {
        return AuthAdmin::user()->id;
    }
}