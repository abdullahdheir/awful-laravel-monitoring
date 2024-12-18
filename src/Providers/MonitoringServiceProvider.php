<?php

namespace Awful\Monitoring\Providers;

use Awful\Monitoring\Middlewares\PageVisitMonitoringMiddleware;
use Illuminate\Support\ServiceProvider;

class MonitoringServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'AwfulMonitoring');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->app->register(MonitoringRouteServiceProvider::class);
        $this->app->register(MonitoringEventServiceProvider::class);
        $this->app['router']->aliasMiddleware('page-monitor-visit-middleware', PageVisitMonitoringMiddleware::class);
        $this->app['router']->pushMiddlewareToGroup(config('auth.defaults.guard'), PageVisitMonitoringMiddleware::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
