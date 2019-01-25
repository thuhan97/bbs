<?php

namespace App\Providers;

use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IEventService;
use App\Services\Contracts\IPostService;
use App\Services\Contracts\IRegulationService;
use App\Services\Contracts\IReportService;
use App\Services\Contracts\IUserService;
use App\Services\Contracts\IWorkTimeService;
use App\Services\DayOffService;
use App\Services\EventService;
use App\Services\PostService;
use App\Services\RegulationService;
use App\Services\ReportService;
use App\Services\UserService;
use App\Services\WorkTimeService;
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
        $this->app->bind(IRegulationService::class, function () {
            return app()->make(RegulationService::class);
        });
        $this->app->bind(IEventService::class, function () {
            return app()->make(EventService::class);
        });
        $this->app->bind(IPostService::class, function () {
            return app()->make(PostService::class);
        });
        $this->app->bind(IReportService::class, function () {
            return app()->make(ReportService::class);
        });

        $this->app->bind(IDayOffService::class, function () {
            return app()->make(DayOffService::class);
        });
        $this->app->bind(IWorkTimeService::class, function () {
            return app()->make(WorkTimeService::class);
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
            IRegulationService::class,
            IReportService::class,
            IEventService::class,
            IPostService::class,
            IDayOffService::class,
            IWorkTimeService::class,
        ];
    }
}
