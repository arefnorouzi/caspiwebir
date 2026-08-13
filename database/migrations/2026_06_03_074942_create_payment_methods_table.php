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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');           // مثلا "پرداخت آنلاین"، "پرداخت در محل"
            $table->string('code', 50)->nullable(); // مثلاً: online, cod, wallet
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('status')->default(true);
            $table->string('api_key')->nullable();
            $table->string('terminal_id')->nullable();
            $table->string('merchant')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_gateway')->default(false);
            $table->boolean('is_loan')->default(false);
            $table->decimal('interest_rate')->default(0);
            $table->unsignedTinyInteger('invoice_type_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
