<?php

namespace Awful\Monitoring\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index(Request $request): Factory|View|Application
    {
        return view('AwfulMonitoring::index');
    }
}
