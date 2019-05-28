<?php

namespace App\Providers;

use App\Models\DayOff;
use App\Models\Event;
use App\Models\Post;
use App\Models\Punishes;
use App\Models\Regulation;
use App\Models\Report;
use App\Models\User;
use App\Models\WorkTime;
use App\Observers\DayOffObserver;
use App\Observers\EventObserver;
use App\Observers\PostObserver;
use App\Observers\PunishObserver;
use App\Observers\RegulationObserver;
use App\Observers\ReportObserver;
use App\Observers\UserObserver;
use App\Observers\WorkTimeObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
        Event::observe(EventObserver::class);
        DayOff::observe(DayOffObserver::class);
        WorkTime::observe(WorkTimeObserver::class);
        Punishes::observe(PunishObserver::class);
        Report::observe(ReportObserver::class);
        Regulation::observe(RegulationObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
