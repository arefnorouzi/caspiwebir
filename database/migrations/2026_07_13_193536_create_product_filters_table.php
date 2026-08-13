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
        Schema::create('product_filters', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('category_filter_item_id');
            $table->unsignedMediumInteger('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_filters');
    }
};
