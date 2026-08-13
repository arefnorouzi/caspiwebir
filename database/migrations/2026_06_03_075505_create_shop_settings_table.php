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
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');
            $table->string('meta')->nullable();
            $table->string('factor_logo')->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->unsignedInteger('tax')->default(0); // 0-100
            $table->unsignedSmallInteger('order_expire')->default(48); //hours
            $table->string('welcome_sms', 100)->nullable();
            $table->string('welcome_sms_pattern_id', 100)->nullable();
            $table->unsignedTinyInteger('stock_alert')->default(5); // نمایش کالاهای ناموجود
            $table->boolean('display_out_of_stock')->default(true); // نمایش کالاهای ناموجود
            $table->boolean('sell_status')->default(true);
            $table->boolean('buy_need_register')->default(false);
            $table->string('add_to_cart_btn', 100)->nullable();
            $table->string('checkout_btn', 100)->nullable();
            $table->string('pay_btn', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
