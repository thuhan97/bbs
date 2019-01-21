<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Config;
use App\Models\Event;
use App\Models\Post;
use App\Models\Team;
use App\Models\User;
use App\Repositories\AdminRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\Contracts\IAdminRepository;
use App\Repositories\Contracts\IConfigRepository;
use App\Repositories\Contracts\IEventRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\ITeamRepository;
use App\Repositories\EventRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

##AUTO_INSERT_USE##
use App\Repositories\Contracts\IRegulationRepository;
use App\Repositories\RegulationRepository;
use App\Models\Regulation;

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
    }

    public function provides()
    {
        return [
            ##AUTO_INSERT_NAME##
			RegulationRepository::class,
            IConfigRepository::class,
            IPostRepository::class,
            IEventRepository::class,
            IAdminRepository::class,
            IUserRepository::class,
        ];
    }
}
