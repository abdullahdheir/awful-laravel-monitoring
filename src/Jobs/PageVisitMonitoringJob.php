<?php

namespace Awful\Monitoring\Jobs;

use Awful\Monitoring\Traits\DBTraits;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PageVisitMonitoringJob implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, DBTraits;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // تسجيل بيانات الزيارة
        $this->dbConnection()->table('page_visit_monitoring')->insert([
            'domain' => request()->getHost(),
            'causer_id' => auth()->id(), // معرف المستخدم (إذا كان مسجلاً الدخول)
            'causer_type' => auth()->check() ? auth()->user()->getMorphClass() : null,
            'link' => request()->fullUrl(), // الرابط الكامل للطلب
            'method' => request()->method(), // نوع الطلب (GET, POST, PUT ...)
            'payload' => json_encode(request()->except(['password', 'password_confirmation'])), // بيانات الطلب (باستثناء الحقول الحساسة)
            'ip_address' => request()->ip(), // عنوان الـ IP
            'user-agent' => json_encode(request()->header('User-Agent')), // بيانات المتصفح
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
