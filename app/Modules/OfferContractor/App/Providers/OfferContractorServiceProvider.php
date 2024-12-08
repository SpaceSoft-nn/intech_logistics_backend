<?php

namespace App\Modules\OfferContractor\App\Providers;

use Carbon\Laravel\ServiceProvider;

class OfferContractorServiceProvider extends ServiceProvider
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
