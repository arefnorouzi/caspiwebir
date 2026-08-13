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
        Schema::create('invoice_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('invoice_id');
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->string('user_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('title')->nullable();
            $table->json('log_data')->nullable();
            $table->timestamp('log_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_logs');
    }
};
