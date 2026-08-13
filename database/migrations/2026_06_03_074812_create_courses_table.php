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
        Schema::create('courses', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('meta')->nullable();
            $table->text('description')->nullable();
            $table->string('source')->nullable();
            $table->string('demo_link')->nullable();
            $table->string('course_time')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('rank')->default(1);
            $table->boolean('status')->default(true);
            $table->unsignedMediumInteger('product_id')->nullable();
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
