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
        Schema::create('banners', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('new_tab')->default(1);
            $table->boolean('status')->default(1);
            $table->unsignedTinyInteger('rank')->default(10);
            $table->unsignedTinyInteger('size')->default(3);
            $table->unsignedTinyInteger('position')->default(1);
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
        Schema::dropIfExists('banners');
    }
};
