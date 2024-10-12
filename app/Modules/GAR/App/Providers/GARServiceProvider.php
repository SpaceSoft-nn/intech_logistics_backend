<?php

namespace App\Modules\GAR\App\Providers;

use App\Modules\GAR\Common\Config\GARConfig;
use App\Modules\GAR\Domain\Services\GARService;
use Dadata\DadataClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class GARServiceProvider extends ServiceProvider
{
    public function register()
    {



        $this->app->scoped(GARService::class, function (Application $app) {

            $config = $app->make(GARConfig::class);
            $dadataLibrary = new DadataClient($config->api_key_dadata, $config->secret_key_dadata);

            return new GARService(client: $dadataLibrary);
        });
    }

    public function boot()
    {
        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Common' . '/Database' . "/Migrations");
        }
    }
}
