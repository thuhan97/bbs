<?php

namespace App\Providers;

use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IEventService;
use App\Services\Contracts\IFeedbackService;
use App\Services\Contracts\IPostService;
use App\Services\Contracts\IRegulationService;
use App\Services\Contracts\IReportService;
use App\Services\Contracts\ITeamService;
use App\Services\Contracts\IUserService;
use App\Services\Contracts\IUserTeamService;
use App\Services\Contracts\IWorkTimeService;
use App\Services\Contracts\IProjectService;
use App\Services\DayOffService;
use App\Services\EventService;
use App\Services\FeedbackService;
use App\Services\PostService;
use App\Services\RegulationService;
use App\Services\ReportService;
use App\Services\TeamService;
use App\Services\UserService;
use App\Services\WorkTimeService;
use App\Services\ProjectService;
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
        $this->app->bind(IUserTeamService::class, function () {
            return app()->make(IUserTeamService::class);
        });
        $this->app->bind(IRegulationService::class, function () {
            return app()->make(RegulationService::class);
        });
        $this->app->bind(ITeamService::class, function () {
            return app()->make(TeamService::class);
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
<<<<<<< HEAD
        $this->app->bind(IProjectService::class, function () {
            return app()->make(ProjectService::class);
=======
        $this->app->bind(IFeedbackService::class, function () {
            return app()->make(FeedbackService::class);
>>>>>>> 1ec7295da90b7d9a568af2072d025a02126c6d03
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
            ITeamService::class,
            IUserTeamService::class,
            IDayOffService::class,
            IWorkTimeService::class,
<<<<<<< HEAD
            IProjectService::class,
=======
            IFeedbackService::class,
>>>>>>> 1ec7295da90b7d9a568af2072d025a02126c6d03
        ];
    }
}
