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
        Schema::create('verify_codes', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->unsignedMediumInteger('user_id');
            $table->string('recipient');
            $table->string('code', 50);
            $table->string('type', 20)->default('sms');
            $table->unsignedInteger('expired_at');
            $table->unsignedInteger('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verify_codes');
    }
};
