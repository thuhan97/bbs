<?php

namespace App\Providers;

use App\Services\Contracts\IEventService;
use App\Services\Contracts\IPostService;
use App\Services\Contracts\IUserService;
use App\Services\EventService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AdditionServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserService::class, function () {
            return app()->make(UserService::class);
        });
        $this->app->bind(IEventService::class, function () {
            return app()->make(EventService::class);
        });
        $this->app->bind(IPostService::class, function () {
            return app()->make(PostService::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            IUserService::class,
            IEventService::class,
            IPostService::class,
        ];
    }
}
