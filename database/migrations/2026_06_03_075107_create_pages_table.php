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
        Schema::create('pages', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug', 120)->unique();
            $table->string('meta')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('menu')->default(0);
            $table->boolean('pinned')->default(0);
            $table->boolean('sidebar')->default(0);
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
