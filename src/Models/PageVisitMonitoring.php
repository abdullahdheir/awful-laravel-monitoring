<?php

namespace Awful\Monitoring\Models;

use Awful\Monitoring\Utils\Detector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisitMonitoring extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'awful_page_visit_monitoring';

    protected $appends = [
        'browser_name',
        'platform',
    ];

    public function causer(): BelongsTo
    {
        return $this->morphTo();
    }

    public function getBrowserNameAttribute(): string
    {
        $detector = new Detector($this->user_agent);
        return $detector->getBrowser();
    }

    public function getPlatformAttribute(): string
    {
        $detector = new Detector($this->user_agent);
        return $detector->getDevice();
    }
}
