<?php

namespace Awful\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogMonitoring extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'awful_activity_log_monitoring';
}
