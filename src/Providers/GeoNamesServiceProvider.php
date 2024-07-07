<?php

namespace Plutuss\GeoNames\Providers;

use Illuminate\Support\ServiceProvider;

class GeoNamesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
//        $this->app->singleton('getid3.media', MediaAnalyzerServiceInterface::class);
//
//        $this->app->singleton(MediaAnalyzerServiceInterface::class, function ($app) {
//            return new MediaAnalyzerService(new \getID3);
//        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
