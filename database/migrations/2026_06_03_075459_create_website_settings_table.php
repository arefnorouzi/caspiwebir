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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');
            $table->string('meta')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 70)->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('factor_logo')->nullable();
            $table->string('address')->nullable();
            $table->text('enamad')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();
            $table->string('x')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('ita')->nullable();
            $table->string('igap')->nullable();
            $table->string('rubika')->nullable();
            $table->string('soroush')->nullable();
            $table->string('bale')->nullable();
            $table->string('aparat')->nullable();
            $table->string('youtube')->nullable();
            $table->string('bg_color')->default('rgb(244, 245, 246)');
            $table->string('default_text')->default('rgb(60, 66, 74)');
            $table->string('primary_text')->default('rgb(244, 90, 90)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
