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
        Schema::create('media', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('media_path')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('file_name')->nullable();
            $table->string('media_type')->nullable();
            $table->string('media_extension', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
