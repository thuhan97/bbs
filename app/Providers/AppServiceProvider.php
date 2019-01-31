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
<<<<<<< HEAD
        $config = Config::firstOrNew(['id' => 1]);
        view()->share('config', $config);
=======
         $config = Config::firstOrNew(['id' => 1]);
         view()->share('config', $config);
>>>>>>> 1ec7295da90b7d9a568af2072d025a02126c6d03
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
