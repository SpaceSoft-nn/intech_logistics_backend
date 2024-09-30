<?php

namespace App\Providers;

use App\Console\Commands\MakeModules;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        //устанавливаем правила для password
        $this->setPasswordDefault();
    }

    private function setPasswordDefault(): void
    {
        Password::defaults(function () {

            return Password::min(6)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();

                // утекшие пароли
                // ->uncompromised();
        });
    }
}
