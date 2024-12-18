<?php

namespace Awful\Monitoring\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // متابعة الطلب
        $response = $next($request);

        // تسجيل بيانات الزيارة
        DB::table('page_visit_monitoring')->insert([
            'causer_id' => auth()->id(), // معرف المستخدم (إذا كان مسجلاً الدخول)
            'causer_type' => auth()->check() ? auth()->user()->getMorphClass() : null,
            'link' => $request->fullUrl(), // الرابط الكامل للطلب
            'method' => $request->method(), // نوع الطلب (GET, POST, PUT ...)
            'payload' => json_encode($request->except(['password', 'password_confirmation'])), // بيانات الطلب (باستثناء الحقول الحساسة)
            'ip_address' => $request->ip(), // عنوان الـ IP
            'user-agent' => json_encode($request->header('User-Agent')), // بيانات المتصفح
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response;
    }
}
