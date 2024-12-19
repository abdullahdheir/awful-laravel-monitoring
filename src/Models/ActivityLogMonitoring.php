<?php

namespace Awful\Monitoring\Models;

use Awful\Monitoring\Traits\DetectorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLogMonitoring extends Model
{
    use HasFactory, DetectorTrait;

    public $timestamps = true;

    protected $table = 'awful_activity_log_monitoring';

    public function getTypeColor(): string
    {
        return match ($this->event_name) {
            'created' => 'blue',
            'updated' => 'purple',
            'deleted' => 'red',
            'restored' => 'yellow',
            'login' => 'pink',
            default => 'gray',
        };
    }

    public function causer(): BelongsTo
    {
        return $this->morphTo();
    }

    public function subject(): BelongsTo
    {
        return $this->morphTo();
    }
}
