<?php

namespace App\Modules\InteractorModules\AddressOrder\App\Providers;

use Illuminate\Support\ServiceProvider;

class AddressOrderServiceProvide extends ServiceProvider
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
