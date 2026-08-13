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
        Schema::create('social_networks', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('position')->nullable()->default('footer');
            $table->boolean('status')->default(true);
            $table->unsignedTinyInteger('rank')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_networks');
    }
};
