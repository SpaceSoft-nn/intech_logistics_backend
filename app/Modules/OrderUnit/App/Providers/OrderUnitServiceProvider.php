<?php

namespace App\Modules\OrderUnit\App\Providers;

use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Azimut\AzimutAlgorithmVectorMovent;
use App\Modules\OrderUnit\Domain\Interactor\Algorithm\VectroMovent\Distance\DistanceAlgorithmVectorMovent;
use App\Modules\OrderUnit\Domain\Interface\Algorithm\IVectorMoventAlgorithm;
use Illuminate\Support\ServiceProvider;

class OrderUnitServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(IVectorMoventAlgorithm::class, DistanceAlgorithmVectorMovent::class);
        $this->app->bind(IVectorMoventAlgorithm::class, AzimutAlgorithmVectorMovent::class);
    }

    public function boot()
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations" . "/Agreement");
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations" . "/CargoGood");
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations" . "/OrderUnit");

        }
    }
}
