<?php

namespace App\Providers;

use App\Policies\PotatoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('manager', 'App\Policies\UsersPolicy@manager');
        Gate::define('team-leader', 'App\Policies\UsersPolicy@teamLeader');
        Gate::define('HCNS', 'App\Policies\UsersPolicy@HCNS');
        Gate::define('BRSE', 'App\Policies\UsersPolicy@BRSE');
        Gate::define('staff', 'App\Policies\UsersPolicy@staff');
    }
}
