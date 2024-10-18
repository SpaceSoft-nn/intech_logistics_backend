<?php

namespace App\Modules\InteractorModules\AdressOrder\App\Providers;

use Illuminate\Support\ServiceProvider;

class AdressOrderServiceProvide extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
