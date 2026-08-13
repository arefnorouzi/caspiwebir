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
        Schema::create('brands', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name');
            $table->string('meta')->nullable();
            $table->string('website', 150)->nullable();
            $table->string('image')->nullable();
            $table->string('slug', 100)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('home_page')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
