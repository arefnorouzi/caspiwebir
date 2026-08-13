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
        Schema::create('categories', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('meta')->nullable();
            $table->string('image')->nullable();
            $table->string('slug', 70)->unique();
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('home_page')->default(false);
            $table->boolean('only_offers')->default(false);
            $table->boolean('menu')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
