<?php

namespace Awful\Monitoring\Providers;

use Awful\Monitoring\Middlewares\PageVisitMonitoringMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        $this->viewComposer();
    }

    /**
     * View Composer.
     *
     * @return void
     */
    private function viewComposer(): void
    {
        view()->composer([
            'AwfulMonitoring::layouts.master',
            'AwfulMonitoring::visit-monitoring.index',
            'AwfulMonitoring::actions-monitoring.index',
            'AwfulMonitoring::authentications-monitoring.index',
        ], function (View $view) {
            $title = 'Awful Monitoring';

            $view->with('title', $title);
        });
    }
}
