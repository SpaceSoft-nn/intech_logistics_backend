<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\App\Providers;

use Carbon\Laravel\ServiceProvider;

class OrganizationOrderInvoiceServiceProvider extends ServiceProvider
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
