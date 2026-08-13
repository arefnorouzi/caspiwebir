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
        Schema::create('icon_boxes', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('meta')->nullable();
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->string('background_color')->nullable();
            $table->string('border_color')->nullable();
            $table->string('text_color')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedTinyInteger('position')->default(3);
            $table->unsignedTinyInteger('rank')->default(10);
            $table->unsignedSmallInteger('size')->default(3);
            $table->unsignedSmallInteger('margin_top')->default(5);
            $table->unsignedSmallInteger('margin_bottom')->default(5);
            $table->unsignedSmallInteger('margin_right')->default(5);
            $table->unsignedSmallInteger('margin_left')->default(5);
            $table->unsignedSmallInteger('padding_top')->default(0);
            $table->unsignedSmallInteger('padding_bottom')->default(0);
            $table->unsignedSmallInteger('padding_right')->default(0);
            $table->unsignedSmallInteger('padding_left')->default(0);
            $table->unsignedSmallInteger('min_width')->default(100);
            $table->unsignedSmallInteger('max_width')->default(300);
            $table->unsignedSmallInteger('min_height')->default(100);
            $table->unsignedSmallInteger('max_height')->default(250);
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
        Schema::dropIfExists('icon_boxes');
    }
};
