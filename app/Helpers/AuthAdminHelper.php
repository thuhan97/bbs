<?php
/**
 * Auth Admin Helper
 * User: jvb
 * Date: 8/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthAdminHelper
{
    /**
     * Get current is logged
     *
     * @return bool
     */
    public static function check()
    {
        return self::guard()->check();
    }

    /**
     * Get current admin id
     *
     * @return int|null
     */
    public static function id()
    {
        return self::guard()->id();
    }

    /**
     * Get current admin
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function user()
    {
        return self::guard()->user();
    }

    /**
     * Get current admin
     * return void
     */
    public static function logout()
    {
        return self::guard()->logout();
    }

    /**
     * @return Auth
     */
    private static function guard()
    {
        return Auth::guard(ADMIN_GUARD);
    }

}
