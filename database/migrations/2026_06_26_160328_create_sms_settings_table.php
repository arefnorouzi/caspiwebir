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
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('code', 30)->unique();
            $table->string('pattern_id', 100)->unique();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('access_hash')->nullable();
            $table->string('receipt', 15)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_settings');
    }
};
