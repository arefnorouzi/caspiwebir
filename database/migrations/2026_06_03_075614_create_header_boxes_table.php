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
        Schema::create('header_boxes', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->date('end_date')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->boolean('status')->default(1);
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('css_class')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_boxes');
    }
};
