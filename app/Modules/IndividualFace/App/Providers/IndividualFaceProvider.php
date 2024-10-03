<?php

namespace App\Modules\IndividualFace\App\Providers;

use Illuminate\Support\ServiceProvider;

class IndividualPeopleServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        dd(1);
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
