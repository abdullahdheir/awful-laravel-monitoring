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
        Schema::create('activity_log_monitoring', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->nullableMorphs('causer','causer');
            $table->nullableMorphs('subject','subject');
            $table->enum('event_name',['created','updated','deleted','restored','forceDeleted']);
            $table->string('link')->nullable();
            $table->string('method')->nullable();
            $table->ipAddress();
            $table->json('user-agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log_monitoring');
    }
};