<?php

namespace Awful\Monitoring\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class MonitoringRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Register files.
     *
     * @return void
     */
    public function register(): void
    {
        // $path = __DIR__ . '/../../routes/web.php';

       // Route::middleware('web')->prefix('awful-monitoring')->name('awful_monitoring.')
       // ->group($path);
    }
}
