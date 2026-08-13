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
        Schema::create('academy_settings', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->unsignedTinyInteger('commission_rate')->default(30);
            $table->unsignedInteger('max_commission_earn')->default(1000000);
            $table->boolean('tax')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_settings');
    }
};
