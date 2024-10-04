<?php

namespace App\Modules\Transfer\App\Providers;

use Illuminate\Support\ServiceProvider;

class TransferServiceProvider extends ServiceProvider
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
