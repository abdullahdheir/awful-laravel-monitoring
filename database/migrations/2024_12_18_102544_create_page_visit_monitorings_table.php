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
        Schema::create('page_visit_monitoring', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('causer','causer');
            $table->string('link');
            $table->string('method')->default('GET');
            $table->json('payload')->nullable();
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
        Schema::dropIfExists('page_visit_monitoring');
    }
};
