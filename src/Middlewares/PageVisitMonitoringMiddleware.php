<?php

namespace Awful\Monitoring\Middlewares;

use Awful\Monitoring\Jobs\PageVisitMonitoringJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageVisitMonitoringMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        dispatch(new PageVisitMonitoringJob())->afterResponse();

        return $response;
    }
}
