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
        Schema::create('carts', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->boolean('status')->default(true);
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->string('session_id')->nullable(); // برای کاربر مهمان
            $table->unsignedInteger('sub_total')->default(0);
            $table->unsignedInteger('discount')->default(0);
            $table->string('coupon_code', 50)->nullable();
            $table->unsignedMediumInteger('coupon_id')->nullable();
            $table->unsignedInteger('total_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
