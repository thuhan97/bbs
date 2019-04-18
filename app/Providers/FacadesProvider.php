<?php

namespace App\Providers;

use App\Helper\ImageHelper;
use App\Helpers\AuthAdminHelper;
use App\Helpers\AuthApiHelper;
use App\Helpers\DatabaseHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\FloatAndIntHelper;
use App\Helpers\SendMailHelper;
use App\Helpers\StringHelper;
use App\Helpers\TranscriptHelper;
use App\Helpers\UrlHelper;
use Illuminate\Support\ServiceProvider;

class FacadesProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('string_helper', function () {
            return new StringHelper();
        });
        $this->app->singleton('date_time_helper', function () {
            return new DateTimeHelper();
        });
        $this->app->singleton('database_helper', function () {
            return new DatabaseHelper();
        });
        $this->app->singleton('send_mail_helper', function () {
            return new SendMailHelper();
        });
        $this->app->singleton('auth_admin_helper', function () {
            return new AuthAdminHelper();
        });
        $this->app->singleton('auth_api_helper', function () {
            return new AuthApiHelper();
        });
        $this->app->singleton('url_helper', function () {
            return new UrlHelper();
        });
        $this->app->singleton('transcript_helper', function () {
            return new TranscriptHelper();
        });
        $this->app->singleton('image_helper', function () {
            return new ImageHelper();
        });
        $this->app->singleton('float_int_helper', function () {
            return new FloatAndIntHelper();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
