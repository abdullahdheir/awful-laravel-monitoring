<?php

namespace Awful\Monitoring\Jobs;

use Awful\Monitoring\Traits\DBTraits;
use Awful\Monitoring\Utils\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ActivityLogMonitoringJob implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DBTraits;

    protected string $eventName;
    protected Model $model;

    /**
     * Create a new job instance.
     */
    public function __construct(string $eventName, Model $model)
    {
        $this->eventName = $eventName;
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('awful_activity_log_monitoring')->insert([
            'domain' => request()->getHost(),
            'description' => $this->generateDescription($this->eventName, $this->model->getOriginal(), $this->model->getDirty()),
            'causer_type' => auth()->check() ? auth()->user()->getMorphClass() : null ,
            'causer_id' => auth()->id(),
            'subject_type' => get_class($this->model),
            'subject_id' => $this->model->getKey(),
            'event_name' => $this->eventName,
            'link' => request()->fullUrl(),
            'method' => request()->method(),
            'ip_address' => request()->ip(),
            'user_agent' => json_encode(request()->header('User-Agent')),
            'properties' => json_encode(Common::getLogProperties(request()->ip())),
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
                if (!in_array($key, ['created_at', 'updated_at', 'password'])) {
                    $newFields[$key] = $value;
                }
            } else {
                unset($oldData[$key]);
            }
        }

        unset($oldData['created_at'], $oldData['updated_at'], $oldData['password']);
        unset($newData['password']);

        $changedFields['from'] = $oldData;
        $changedFields['to'] = $newFields;

        return $changedFields;
    }
}
