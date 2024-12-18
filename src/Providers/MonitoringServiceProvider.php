<?php

namespace Awful\Monitoring\Providers;

use Illuminate\Support\ServiceProvider;

class MonitoringServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'awful::monitoring');
        $this->app->register(MonitoringRouteServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
