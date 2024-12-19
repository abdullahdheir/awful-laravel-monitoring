<?php

namespace Awful\Monitoring\Controllers;

use Awful\Monitoring\Models\ActivityLogMonitoring;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActivityLogMonitoringController extends BaseController
{
    public function index(Request $request): Factory|View|Application
    {
        $activityLogs = ActivityLogMonitoring::query()->whereNotIn('event_name', ['login', 'logout'])->latest()->paginate();
        return view('AwfulMonitoring::activity-logs-monitoring.index', compact('activityLogs'));
    }

    public function delete(Request $request, $id): RedirectResponse
    {
        $activityLog = ActivityLogMonitoring::query()->findOrFail($id);
        $activityLog->delete();
        return redirect()->back()->with('message', 'The page visit has been deleted successfully');
    }
}
