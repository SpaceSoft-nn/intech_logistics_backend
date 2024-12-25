<?php

namespace App\Modules\Tender\App\Providers;

use Illuminate\Support\ServiceProvider;

class TenderServiceProvider extends ServiceProvider
{
    public function boot()
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");

        }
    }
}
