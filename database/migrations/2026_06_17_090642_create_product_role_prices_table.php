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
        Schema::create('product_role_prices', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('product_id');
            $table->unsignedMediumInteger('product_variant_id')->nullable();
            $table->unsignedMediumInteger('role_id');
            $table->unsignedInteger('price');
            $table->unsignedInteger('offer_price')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_role_prices');
    }
};
