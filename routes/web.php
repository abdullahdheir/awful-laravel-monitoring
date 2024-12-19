<?php

use Awful\Monitoring\Controllers\ActivityLogMonitoringController;
use Awful\Monitoring\Controllers\AuthenticationMonitoringController;
use Awful\Monitoring\Controllers\PageVisitMonitoringController;
use Illuminate\Support\Facades\Route;

Route::prefix('page-visits-monitoring')->name('page_visits_monitoring.')->controller(PageVisitMonitoringController::class)->group(function (){
   Route::get('','index')->name('index');
   Route::delete('{id}/delete','delete')->name('delete');
});

Route::prefix('activity_log_monitoring')->name('activity_log_monitoring.')->controller(ActivityLogMonitoringController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::delete('{id}/delete', 'delete')->name('delete');
});

Route::prefix('authentications_monitoring')->name('authentications_monitoring.')->controller(AuthenticationMonitoringController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::delete('{id}/delete', 'delete')->name('delete');
});
