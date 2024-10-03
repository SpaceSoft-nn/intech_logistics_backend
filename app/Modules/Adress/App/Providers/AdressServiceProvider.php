<?php

namespace App\Modules\Adress\App\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class AdressServiceProvider extends ServiceProvider
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
