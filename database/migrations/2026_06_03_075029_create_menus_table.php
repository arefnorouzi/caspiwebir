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
        Schema::create('menus', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug', 120)->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('css_class')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->boolean('pinned')->default(0);
            $table->string('position', 70)->default('main_menu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
