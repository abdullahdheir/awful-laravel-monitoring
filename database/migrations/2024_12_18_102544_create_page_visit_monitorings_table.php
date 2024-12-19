<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('awful_page_visit_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->nullableMorphs('causer','causer');
            $table->string('link');
            $table->string('method')->default('GET');
            $table->json('payload')->nullable();
            $table->ipAddress();
            $table->json('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awful_page_visit_monitoring');
    }
};
