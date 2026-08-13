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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('invoice_id');
            $table->unsignedMediumInteger('product_id')->nullable();
            $table->unsignedMediumInteger('product_variant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('unit_price')->default(0);
            $table->unsignedSmallInteger('qty')->default(1);
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('item_price')->default(0);
            $table->unsignedInteger('shipping_cost')->default(0);
            $table->unsignedTinyInteger('invoice_item_status_id') ->default(1);
            $table->unsignedTinyInteger('seller_commission')->default(0); // کمیسیون فروشنده یا مدرس
            $table->unsignedInteger('seller_earning')->default(0); // مبلغی که باید به فروشنده یا مدرس برسد
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
