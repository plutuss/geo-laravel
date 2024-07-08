<?php

namespace Plutuss\GeoNames\Providers;

use Illuminate\Support\ServiceProvider;
use Plutuss\GeoNames\Services\GeoNameClientService;
use Plutuss\GeoNames\Services\GeoNameService;
use Plutuss\GeoNames\Services\GeoNameServiceInterface;

class GeoNamesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('geo.name.app', GeoNameServiceInterface::class);

        $this->app->singleton(GeoNameServiceInterface::class, function ($app) {
            $client = GeoNameClientService::getInstance();
            return GeoNameService::getInstance($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/geo-names.php' => config_path('geo-names.php'),
        ]);
    }
}
