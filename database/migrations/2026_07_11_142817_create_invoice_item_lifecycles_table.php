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
        Schema::create('invoice_item_lifecycles', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->unsignedMediumInteger('invoice_id');
            $table->unsignedInteger('invoice_item_id');
            $table->unsignedTinyInteger('invoice_item_step_id');
            $table->boolean('status')->default(0);
            $table->boolean('pinned')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_item_lifecycles');
    }
};
