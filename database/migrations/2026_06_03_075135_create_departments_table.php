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
        Schema::create('departments', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->string('code', 30)->unique(); // کد یکتا برای دپارتمان
            $table->string('internal_phone')->nullable(); // کد داخلی تلفن سنترال
            $table->text('description')->nullable(); // توضیحات
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
