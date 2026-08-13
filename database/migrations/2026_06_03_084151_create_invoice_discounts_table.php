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
        Schema::create('invoice_discounts', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('coupon_code', 50)->nullable();
            $table->unsignedMediumInteger('coupon_id')->nullable();
            $table->unsignedMediumInteger('invoice_id')->nullable();
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_discounts');
    }
};
