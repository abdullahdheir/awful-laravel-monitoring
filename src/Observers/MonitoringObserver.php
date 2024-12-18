<?php

namespace Awful\Monitoring\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        DB::table('activity_log_monitoring')->insert([
            'description' => $this->generateDescription($eventName, $model->getOriginal(), $model->getDirty()),
            'causer_type' => auth()->check() ? auth()->user()->getMorphClass() : null,
            'causer_id' => auth()->id(),
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
            'event_name' => $eventName,
            'link' => request()->fullUrl(),
            'method' => request()->method(),
            'ip_address' => request()->ip(),
            'user-agent' => json_encode(request()->header('User-Agent')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function generateDescription(string $eventName, array $oldData, array $newData): string
    {
        $description = 'Performed ' . $eventName . ' operation.';

        if ($eventName === 'created') {
            // تفاصيل السجل المُنشأ
            $description .= ' Created record with the following values: ' . json_encode($newData);
        } elseif ($eventName === 'updated') {
            // تفاصيل الحقول المُعدلة
            $changes = $this->getChangedFields($oldData, $newData);
            $description .= ' Updated the following fields: ' . json_encode($changes);
        } elseif ($eventName === 'deleted') {
            // تفاصيل السجل المحذوف
            $description .= ' Deleted record with the following values: ' . json_encode($oldData);
        }

        return $description;
    }

    protected function getChangedFields(array $oldData, array $newData): array
    {
        $changedFields = [];
        $newFields = [];

        foreach ($newData as $key => $value) {
            if (Arr::get($oldData, $key) !== $value) {
                if (!in_array($key, ['created_at', 'updated_at','password'])) {
                    $newFields[$key] = $value;
                }
            } else {
                unset($oldData[$key]);
            }
        }

        unset($oldData['created_at'], $oldData['updated_at'],$oldData['password']);
        unset($newData['password']);

        $changedFields['from'] = $oldData;
        $changedFields['to'] = $newFields;

        return $changedFields;
    }

}
