<?php

namespace Awful\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisitMonitoring extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'page_visit_monitoring';
}
