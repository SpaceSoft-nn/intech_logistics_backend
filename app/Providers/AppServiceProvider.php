<?php

namespace App\Providers;

use App\Console\Commands\MakeModules;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            MakeModules::class,
        ]);
    }

    public function boot(): void
    {

    }
}
