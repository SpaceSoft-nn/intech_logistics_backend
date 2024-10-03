<?php

namespace App\Modules\IndividualFace\App\Providers;

use Illuminate\Support\ServiceProvider;

class IndividualFaceServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
        }
    }
}
