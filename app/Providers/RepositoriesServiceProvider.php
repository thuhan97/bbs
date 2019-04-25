<?php

namespace App\Providers;

use App\Models\ActionDevice;
use App\Models\Admin;
use App\Models\Config;
use App\Models\DayOff;
use App\Models\Device;
use App\Models\DeviceUser;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Feedback;
use App\Models\Meeting;
use App\Models\OverTime;
use App\Models\Post;
use App\Models\Project;
use App\Models\Punishes;
use App\Models\Regulation;
use App\Models\Report;
use App\Models\Rules;
use App\Models\Statistics;
use App\Models\Team;
use App\Models\User;
use App\Models\UserTeam;
use App\Models\WorkTime;
use App\Models\WorkTimeDetail;
use App\Models\WorkTimeRegister;
use App\Repositories\ActionDeviceRepository;
use App\Repositories\AdminRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\Contracts\IActionDeviceRepository;
use App\Repositories\Contracts\IAdminRepository;
use App\Repositories\Contracts\IConfigRepository;
use App\Repositories\Contracts\IDayOffRepository;
use App\Repositories\Contracts\IDeviceRepository;
use App\Repositories\Contracts\IDeviceUserRepository;
use App\Repositories\Contracts\IEventAttendanceRepository;
use App\Repositories\Contracts\IEventRepository;
use App\Repositories\Contracts\IFeedbackRepository;
use App\Repositories\Contracts\IMeetingRepository;
use App\Repositories\Contracts\IOverTimeRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IProjectRepository;
use App\Repositories\Contracts\IPunishesRepository;
use App\Repositories\Contracts\IRegulationRepository;
use App\Repositories\Contracts\IReportRepository;
use App\Repositories\Contracts\IRulesRepository;
use App\Repositories\Contracts\IStatisticRepository;
use App\Repositories\Contracts\ITeamRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Repositories\Contracts\IWorkTimeDetailRepository;
use App\Repositories\Contracts\IWorkTimeRegisterRepository;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Repositories\DayOffRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\DeviceUserRepository;
use App\Repositories\EventAttendanceRepository;
use App\Repositories\EventRepository;
use App\Repositories\FeedbackRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OverTimeRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\PunishesRepository;
use App\Repositories\RegulationRepository;
use App\Repositories\ReportRepository;
use App\Repositories\RulesRepository;
use App\Repositories\StatisticRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserTeamRepository;
use App\Repositories\WorkTimeDetailRepository;
use App\Repositories\WorkTimeRegisterRepository;
use App\Repositories\WorkTimeRepository;
use Illuminate\Support\ServiceProvider;

##AUTO_INSERT_USE##

class RepositoriesServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        ##AUTO_INSERT_BIND##
        $this->app->bind(IPunishesRepository::class, function () {
            return new PunishesRepository(new Punishes());
        });
        $this->app->bind(IRulesRepository::class, function () {
            return new RulesRepository(new Rules());
        });
        $this->app->bind(IDeviceUserRepository::class, function () {
            return new DeviceUserRepository(new DeviceUser());
        });
        $this->app->bind(IActionDeviceRepository::class, function () {
            return new ActionDeviceRepository(new ActionDevice());
        });
        $this->app->bind(IDeviceRepository::class, function () {
            return new DeviceRepository(new Device());
        });
        $this->app->bind(IEventAttendanceRepository::class, function () {
            return new EventAttendanceRepository(new EventAttendance());
        });
        $this->app->bind(IEventAttendanceRepository::class, function () {
            return new EventAttendanceRepository(new EventAttendance());
        });
        $this->app->bind(IProjectRepository::class, function () {
            return new ProjectRepository(new Project());
        });
        $this->app->bind(IFeedbackRepository::class, function () {
            return new FeedbackRepository(new Feedback());
        });
        $this->app->bind(IOverTimeRepository::class, function () {
            return new OverTimeRepository(new OverTime());
        });
        $this->app->bind(IWorkTimeDetailRepository::class, function () {
            return new WorkTimeDetailRepository(new WorkTimeDetail());
        });
        $this->app->bind(IWorkTimeRepository::class, function () {
            return new WorkTimeRepository(new WorkTime());
        });

        $this->app->bind(IStatisticRepository::class, function () {
            return new StatisticRepository(new Statistics());
        });

        $this->app->bind(IDayOffRepository::class, function () {
            return new DayOffRepository(new DayOff());
        });
        $this->app->bind(IReportRepository::class, function () {
            return new ReportRepository(new Report());
        });
        $this->app->bind(IRegulationRepository::class, function () {
            return new RegulationRepository(new Regulation());
        });
        $this->app->bind(IAdminRepository::class, function () {
            return new AdminRepository(new Admin());
        });
        $this->app->bind(IConfigRepository::class, function () {
            return new ConfigRepository(new Config());
        });
        $this->app->bind(IPostRepository::class, function () {
            return new PostRepository(new Post());
        });

        $this->app->bind(IEventRepository::class, function () {
            return new EventRepository(new Event());
        });
        $this->app->bind(IUserRepository::class, function () {
            return new UserRepository(new User());
        });
        $this->app->bind(ITeamRepository::class, function () {
            return new TeamRepository(new Team());
        });
        $this->app->bind(IUserTeamRepository::class, function () {
            return new UserTeamRepository(new UserTeam());
        });
        $this->app->bind(IWorkTimeRegisterRepository::class, function () {
            return new WorkTimeRegisterRepository(new WorkTimeRegister());
        });
        $this->app->bind(IProjectRepository::class, function () {
            return new ProjectRepository(new Project());
        });
        $this->app->bind(IMeetingRepository::class, function () {
            return new MeetingRepository(new Meeting());
        });
    }


    public function provides()
    {
        return [
            ##AUTO_INSERT_NAME##
            IPunishesRepository::class,
            IRulesRepository::class,
            IDeviceUserRepository::class,
            IActionDeviceRepository::class,
            IDeviceRepository::class,
            IEventAttendanceRepository::class,
            IProjectRepository::class,
            IFeedbackRepository::class,
            IReportRepository::class,
            IRegulationRepository::class,
            IConfigRepository::class,
            IPostRepository::class,
            IEventRepository::class,
            IAdminRepository::class,
            IUserRepository::class,
            IDayOffRepository::class,
            IOverTimeRepository::class,
            IWorkTimeRepository::class,
            IStatisticRepository::class,
            ITeamRepository::class,
            IUserTeamRepository::class,
            IWorkTimeRegisterRepository::class,
            IProjectRepository::class,
            IMeetingRepository::class
        ];
    }
}
