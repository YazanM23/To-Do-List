<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use App\Listeners\Listener;
use App\Events\CreateTask;
use App\Events\LoggedOut;
use App\Events\LoggedIn;
use App\Events\UpdatedTask;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        Paginator::useBootstrap();
        Event::listen(
            CreateTask::class,
            Listener::class,

        );
        Event::listen(
            LoggedIn::class,
            Listener::class,

        );
        Event::listen(
            LoggedOut::class,
            Listener::class,

        );
        Event::listen(
            UpdatedTask::class,
            Listener::class,

        );
    }
}
