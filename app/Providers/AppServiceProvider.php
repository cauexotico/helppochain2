<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Blockchain;
use App\Project;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('projects')) {
            View::share('dashboardBlockchains', Blockchain::all());
        }
        if (\Schema::hasTable('blockchains')) {
            View::share('dashboardProjects', Project::all());
        }
    }
}
