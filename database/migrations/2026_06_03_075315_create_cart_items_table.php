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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->unsignedMediumInteger('cart_id');
            $table->unsignedMediumInteger('product_id'); // برای محصولات ساده
            $table->unsignedMediumInteger('product_variant_id')->nullable(); // برای محصولات ساده
            $table->string('name', 200)->nullable();
            $table->unsignedSmallInteger('qty')->default(1);
            $table->unsignedInteger('unit_price')->default(0); // قیمت در زمان افزودن به سبد
            $table->unsignedInteger('item_price')->default(0); // قیمت بدون تخفیف
            $table->unsignedTinyInteger('seller_commission')->default(0); // کمیسیون فروشنده یا مدرس
            $table->unsignedInteger('seller_earning')->default(0); // مبلغی که باید به فروشنده یا مدرس برسد
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
