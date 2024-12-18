<?php

use Awful\Monitoring\Controllers\PageVisitMonitoringController;
use Illuminate\Support\Facades\Route;

Route::prefix('page-visits-monitoring')->name('page_visits_monitoring.')->controller(PageVisitMonitoringController::class)->group(function (){
   Route::get('','index')->name('index');
   Route::delete('{id}/delete','delete')->name('delete');
});
