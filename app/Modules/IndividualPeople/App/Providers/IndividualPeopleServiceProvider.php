<?php

namespace App\Modules\IndividualPeople\App\Providers;

use Illuminate\Support\ServiceProvider;

class IndividualPeopleServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations" . "/TypePeople");

        }
    }
}
