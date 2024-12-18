<?php

namespace Awful\Monitoring\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class MonitoringRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Register files.
     *
     * @return void
     */
    public function register(): void
    {
        $path = __DIR__ . '/../../routes/web.php';

        Route::middleware('web')
            ->group($path);
    }
}
