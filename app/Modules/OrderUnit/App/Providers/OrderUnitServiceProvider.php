<?php

namespace App\Modules\OrderUnit\App\Providers;

use Illuminate\Support\ServiceProvider;

class OrderUnitServiceProvider extends ServiceProvider
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
