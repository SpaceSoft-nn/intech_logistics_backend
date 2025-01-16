<?php

namespace App\Modules\Avizo\App\Providers;

use Illuminate\Support\ServiceProvider;

class AvizoServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
        }
    }
}
