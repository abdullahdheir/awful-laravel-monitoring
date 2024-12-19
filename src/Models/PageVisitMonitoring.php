<?php

namespace Awful\Monitoring\Models;

use Awful\Monitoring\Traits\DetectorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisitMonitoring extends Model
{
    use HasFactory, DetectorTrait;

    public $timestamps = true;

    protected $table = 'awful_page_visit_monitoring';

    public function causer(): BelongsTo
    {
        return $this->morphTo();
    }

}
