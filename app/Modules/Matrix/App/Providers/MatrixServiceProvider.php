<?php

namespace App\Modules\Matrix\App\Providers;

use Illuminate\Support\ServiceProvider;

class MatrixServiceProvider extends ServiceProvider
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
