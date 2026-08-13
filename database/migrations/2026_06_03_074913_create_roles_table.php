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
        Schema::create('roles', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name', 70);
            $table->boolean('status')->default(true);
            $table->boolean('loan')->default(true);
            $table->boolean('installment')->default(true);
            $table->boolean('bank_check')->default(false);
            $table->decimal('commission_rate', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
