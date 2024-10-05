<?php

namespace App\Modules\Transport\App\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class TransportServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
    }
}
