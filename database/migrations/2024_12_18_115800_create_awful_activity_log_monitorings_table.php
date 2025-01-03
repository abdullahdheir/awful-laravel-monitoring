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
        Schema::create('awful_activity_log_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->longText('description')->nullable();
            $table->nullableMorphs('causer','causer');
            $table->nullableMorphs('subject','subject');
            $table->enum('event_name', ['created', 'updated', 'deleted', 'restored', 'forceDeleted', 'login', 'logout']);
            $table->string('link')->nullable();
            $table->string('method')->nullable();
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
        Schema::dropIfExists('awful_activity_log_monitoring');
    }
};
