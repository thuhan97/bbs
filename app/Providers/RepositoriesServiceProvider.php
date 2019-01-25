<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Config;
use App\Models\Event;
use App\Models\Post;
use App\Models\Team;
use App\Models\UserTeam;
use App\Models\Regulation;
use App\Models\Report;
use App\Models\User;
use App\Repositories\AdminRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\Contracts\IAdminRepository;
use App\Repositories\Contracts\IConfigRepository;
use App\Repositories\Contracts\IEventRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IRegulationRepository;
use App\Repositories\Contracts\IReportRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\ITeamRepository;
use App\Repositories\Contracts\IUserTeamRepository;
use App\Repositories\EventRepository;
use App\Repositories\PostRepository;
use App\Repositories\RegulationRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserTeamRepository;
use Illuminate\Support\ServiceProvider;

##AUTO_INSERT_USE##
use App\Repositories\Contracts\IOverTimeRepository;
use App\Repositories\OverTimeRepository;
use App\Models\OverTime;
use App\Repositories\Contracts\IWorkTimeDetailRepository;
use App\Repositories\WorkTimeDetailRepository;
use App\Models\WorkTimeDetail;
use App\Repositories\Contracts\IWorkTimeRepository;
use App\Repositories\WorkTimeRepository;
use App\Models\WorkTime;
use App\Repositories\Contracts\IDayOffRepository;
use App\Repositories\DayOffRepository;
use App\Models\DayOff;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        ##AUTO_INSERT_BIND##
		$this->app->bind(IOverTimeRepository::class, function () {
			return new OverTimeRepository(new OverTime());
		});
		$this->app->bind(IWorkTimeDetailRepository::class, function () {
			return new WorkTimeDetailRepository(new WorkTimeDetail());
		});
		$this->app->bind(IWorkTimeRepository::class, function () {
			return new WorkTimeRepository(new WorkTime());
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
    }

    public function provides()
    {
        return [
            ##AUTO_INSERT_NAME##
			OverTimeRepository::class,
			WorkTimeDetailRepository::class,
			WorkTimeRepository::class,
			DayOffRepository::class,
            ReportRepository::class,
            RegulationRepository::class,
            IConfigRepository::class,
            IPostRepository::class,
            IEventRepository::class,
            IAdminRepository::class,
            IUserRepository::class,
        ];
    }
}
