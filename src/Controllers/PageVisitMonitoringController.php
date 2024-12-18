<?php

namespace Awful\Monitoring\Controllers;

use Awful\Monitoring\Models\PageVisitMonitoring;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageVisitMonitoringController extends BaseController
{
    public function index(Request $request): Factory|View|Application
    {
        $visits = PageVisitMonitoring::query()->latest()->paginate();
        return view('AwfulMonitoring::page-visits-monitoring.index', compact('visits'));
    }

    public function delete(Request $request, $id): RedirectResponse
    {
        $visit = PageVisitMonitoring::query()->findOrFail($id);
        $visit->delete();
        return redirect()->back()->with('message', 'The page visit has been deleted successfully');
    }
}
