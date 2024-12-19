<?php

namespace Awful\Monitoring\Controllers;

use Awful\Monitoring\Models\ActivityLogMonitoring;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthenticationMonitoringController extends BaseController
{
    public function index(Request $request): Factory|View|Application
    {
        $authentications = ActivityLogMonitoring::query()->whereIn('event_name', ['login', 'logout'])->latest()->paginate();
        return view('AwfulMonitoring::authentications-monitoring.index', compact('authentications'));
    }

    public function delete(Request $request, $id): RedirectResponse
    {
        $authentication = ActivityLogMonitoring::query()->findOrFail($id);
        $authentication->delete();
        return redirect()->back()->with('message', 'The page visit has been deleted successfully');
    }
}
