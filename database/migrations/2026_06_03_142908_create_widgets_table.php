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
        Schema::create('widgets', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#212121');
            $table->unsignedTinyInteger('rank')->default(10);
            $table->unsignedTinyInteger('position')->default(3);
            $table->unsignedSmallInteger('max_height')->default(450);
            $table->boolean('status')->default(1);
            $table->boolean('has_header')->default(1);
            $table->boolean('has_footer')->default(1);
            $table->boolean('only_image')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
