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
        Schema::create('coupons', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->string('code')->unique();
            $table->enum('coupon_type', ['percent', 'fixed']); // درصدی یا مبلغ ثابت
            $table->decimal('value', 12, 2);            // مقدار تخفیف
            $table->decimal('min_purchase', 12, 2)->nullable(); // حداقل مبلغ خرید
            $table->unsignedInteger('max_usage')->default(100);   // تعداد دفعات استفاده مجاز
            $table->unsignedTinyInteger('max_user_usage')->default(1);   // تعداد دفعات استفاده مجاز
            $table->unsignedInteger('used_count')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
