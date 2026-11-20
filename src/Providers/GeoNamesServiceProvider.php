<?php

namespace Plutuss\GeoNames\Providers;

use Illuminate\Support\ServiceProvider;
use Plutuss\GeoNames\Services\GeoNameService;
use Plutuss\GeoNames\Services\GeoNameServiceInterface;

class GeoNamesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/geo-names.php', 'geo-names');

        $this->app->scoped(GeoNameServiceInterface::class, GeoNameService::class);
        $this->app->alias(GeoNameServiceInterface::class, 'geo.name.app');
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
