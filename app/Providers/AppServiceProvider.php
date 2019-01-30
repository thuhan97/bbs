<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        \Schema::defaultStringLength(191);
        // $config = Config::firstOrNew(['id' => 1]);
        // view()->share('config', $config);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
