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
        Schema::create('students', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('student_code')->nullable();
            $table->string('access_code')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('gender')->default(1);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('purchased')->default(0);
            $table->unsignedInteger('debt')->default(0);
            $table->unsignedMediumInteger('product_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('exam_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
