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
        Schema::create('product_sliders', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#212121');
            $table->unsignedTinyInteger('rank')->default(10);
            $table->unsignedTinyInteger('position')->default(3);
            $table->unsignedTinyInteger('product_limit')->default(10);
            $table->unsignedSmallInteger('brand_id')->nullable();
            $table->unsignedSmallInteger('category_id')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedSmallInteger('page_section_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sliders');
    }
};
