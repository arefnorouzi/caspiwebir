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
        Schema::create('invoices', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('uuid');
            $table->string('session_id')->nullable(); // برای کاربر مهمان
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedInteger('sub_total')->default(0);
            $table->unsignedInteger('shipping_cost')->default(0);
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('tax')->default(0);
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('purchased_amount')->default(0);
            $table->unsignedInteger('interest_amount')->default(0);
            $table->boolean('confirmed_by_user')->default(false);
            $table->boolean('payment_status')->default(false);
            $table->unsignedTinyInteger('invoice_status_id')->default(1);
            $table->unsignedTinyInteger('invoice_type_id')->default(1);
            $table->boolean('paid_with_balance')->default(0);
            $table->boolean('payable')->default(1);
            $table->boolean('admin_created')->default(false);
            $table->string('customer_name', 100)->nullable();
            $table->string('customer_mobile', 30)->nullable();
            $table->string('customer_state', 70)->nullable();
            $table->string('customer_city', 70)->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_zip_code', 20)->nullable();
            $table->string('customer_card_number', 30)->nullable();
            $table->string('customer_sheba', 30)->nullable();
            $table->string('customer_note')->nullable();
            $table->unsignedTinyInteger('payment_method_id')->nullable(); // online, wallet, cod, etc.
            $table->unsignedTinyInteger('shipping_method_id')->nullable(); // post, tipax, barbari, delivery
            $table->string('bank_invoice_token')->nullable();
            $table->string('bank_trans_id')->nullable();
            $table->text('bank_payment_code')->nullable();
            $table->unsignedTinyInteger('failed_attempts')->default(0);
            $table->timestamp('purchased_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
