<?php

namespace Awful\Monitoring\Providers;

use Awful\Monitoring\Jobs\ActivityLogMonitoringJob;
use Awful\Monitoring\Observers\MonitoringObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

class MonitoringEventServiceProvider extends EventServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $modelsPath = app_path('Models');
        $namespace = 'App\\Models\\';

        // تحقق إذا كان المجلد موجودًا
        if (!is_dir($modelsPath)) {
            return;
        }

        // احصل على جميع ملفات PHP في مجلد Models
        $modelFiles = File::files($modelsPath);

        foreach ($modelFiles as $file) {
            $fileName = $file->getFilenameWithoutExtension();
            $class = $namespace . $fileName;

            // تحقق إذا كانت هذه الكلاس موجودة وهي ترث من Model
            if (class_exists($class) && is_subclass_of($class, Model::class)) {
                $class::observe(MonitoringObserver::class);
            }
        }

        // Define the authentication events
        Event::listen(function (Login $event) {
            dispatch(new ActivityLogMonitoringJob("login", $event->user))->afterResponse();
        });

        Event::listen(function (Logout $event) {
            dispatch(new ActivityLogMonitoringJob("logout", $event->user))->afterResponse();
        });
    }
}
