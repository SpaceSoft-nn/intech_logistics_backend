<?php

namespace App\Modules\PalletSpace\App\Providers;

use Illuminate\Support\ServiceProvider;

class PalletSpaceServiceProvider extends ServiceProvider
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
