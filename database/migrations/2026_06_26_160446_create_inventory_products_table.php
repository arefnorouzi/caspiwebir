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
        Schema::create('inventory_products', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('product_id');
            $table->unsignedMediumInteger('product_variant_id')->nullable();
            $table->unsignedSmallInteger('inventory_id');
            $table->unsignedMediumInteger('qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_products');
    }
};
