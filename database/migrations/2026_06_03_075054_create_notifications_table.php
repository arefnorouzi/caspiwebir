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
        Schema::create('notifications', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name');
            $table->string('meta')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('pinned')->default(0);
            $table->boolean('dashboard')->default(0);
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
        Schema::dropIfExists('notifications');
    }
};
