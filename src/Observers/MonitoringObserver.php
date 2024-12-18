<?php

namespace Awful\Monitoring\Observers;

use Awful\Monitoring\Jobs\ActivityLogMonitoringJob;
use Illuminate\Database\Eloquent\Model;

class MonitoringObserver
{
    /**
     * Handle the Model "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model): void
    {
        $this->logActivity($model, 'created');
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param Model $model
     * @return void
     */
    public function updated(Model $model): void
    {
        $this->logActivity($model, 'updated');
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model): void
    {
        $this->logActivity($model, 'deleted');
    }

    /**
     * Handle the Model "restored" event.
     *
     * @param Model $model
     * @return void
     */
    public function restored(Model $model): void
    {
        $this->logActivity($model, 'restored');
    }

    /**
     * Handle the Model "force deleted" event.
     *
     * @param Model $model
     * @return void
     */
    public function forceDeleted(Model $model): void
    {
        $this->logActivity($model, 'forceDeleted');
    }

    /**
     * Log activity to the database.
     *
     * @param Model $model
     * @param string $eventName
     * @return void
     */
    protected function logActivity(Model $model, string $eventName): void
    {
        dispatch(new ActivityLogMonitoringJob($eventName, $model))->afterResponse();
    }

}
