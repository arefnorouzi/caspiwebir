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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('product_id');
            $table->string('name')->nullable();
            $table->string('meta')->nullable();
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->string('code',50)->nullable(); // Stock Keeping Unit
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('offer_price')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->string('image')->nullable(); // Specific image for this variant
            $table->boolean('status')->default(true);
            $table->boolean('is_default')->default(false);
            $table->unsignedMediumInteger('sales')->default(0);
            $table->unsignedSmallInteger('stock')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
