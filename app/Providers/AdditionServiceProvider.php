<?php

namespace App\Providers;

use App\Services\ActionDeviceService;
use App\Services\Contracts\IActionDeviceService;
use App\Services\Contracts\IDayOffService;
use App\Services\Contracts\IDeviceService;
use App\Services\Contracts\IDeviceUserService;
use App\Services\Contracts\IEventService;
use App\Services\Contracts\IFeedbackService;
use App\Services\Contracts\IOverTimeService;
use App\Services\Contracts\IPostService;
use App\Services\Contracts\IProjectService;
use App\Services\Contracts\IRegulationService;
use App\Services\Contracts\IReportService;
use App\Services\Contracts\IStatisticService;
use App\Services\Contracts\ITeamService;
use App\Services\Contracts\IUserService;
use App\Services\Contracts\IUserTeamService;
use App\Services\Contracts\IWorkTimeService;
use App\Services\Contracts\IEventAttendanceService;
use App\Services\Contracts\IMeetingService;
use App\Services\DayOffService;
use App\Services\DeviceService;
use App\Services\DeviceUserService;
use App\Services\EventService;
use App\Services\FeedbackService;
use App\Services\PostService;
use App\Services\ProjectService;
use App\Services\RegulationService;
use App\Services\ReportService;
use App\Services\StatisticService;
use App\Services\TeamService;
use App\Services\UserService;
use App\Services\WorkTimeService;
use App\Services\WorkTimeRegisterService;
use App\Services\Contracts\IWorkTimeRegisterService;
use App\Services\EventAttendanceService;
use App\Services\MeetingService;
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
        $this->app->bind(IStatisticService::class, function () {
            return app()->make(StatisticService::class);
        });
        $this->app->bind(IEventAttendanceService::class, function () {
            return app()->make(EventAttendanceService::class);
        });
        $this->app->bind(IProjectService::class, function () {
            return app()->make(ProjectService::class);
        });
        $this->app->bind(IFeedbackService::class, function () {
            return app()->make(FeedbackService::class);
        });
        $this->app->bind(IActionDeviceService::class, function () {
            return app()->make(ActionDeviceService::class);
        });
        $this->app->bind(IDeviceService::class, function () {
            return app()->make(DeviceService::class);
        });
        $this->app->bind(IDeviceUserService::class, function () {
            return app()->make(DeviceUserService::class);
        });
        $this->app->bind(IWorkTimeRegisterService::class, function () {
            return app()->make(WorkTimeRegisterService::class);
        });
        $this->app->bind(IMeetingService::class, function () {
            return app()->make(MeetingService::class);
        });
        $this->app->bind(IOverTimeService::class, function () {
            return app()->make(IOverTimeService::class);
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
            IStatisticService::class,
            IEventAttendanceService::class,
            IProjectService::class,
            IFeedbackService::class,
            IActionDeviceService::class,
            IDeviceService::class,
            IDeviceUserService::class,
            IWorkTimeRegisterService::class,
            IMeetingService::class,
            IOverTimeService::class,
        ];
    }
}
