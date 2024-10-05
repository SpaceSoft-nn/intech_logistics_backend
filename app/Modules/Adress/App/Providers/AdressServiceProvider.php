<?php

namespace App\Modules\Adress\App\Providers;

use App\Modules\Adress\Common\Database\Seeders\AdressSeeder;
use Closure;
use Illuminate\Support\ServiceProvider;

class AdressServiceProvider extends ServiceProvider
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

    /**
        * Call the seeders.
        *
        * @return void
        */
        protected function callSeeders()
        {
            // $seeders = [
            //     \App\Modules\Adress\Common\Database\Seeders\AdressSeeder::class,
            //     // Добавьте здесь другие сидеры, если необходимо
            // ];

            // foreach ($seeders as $seeder) {
            //     if (class_exists($seeder)) {
            //         \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => $seeder]);
            //     }
            // }
        }
}
