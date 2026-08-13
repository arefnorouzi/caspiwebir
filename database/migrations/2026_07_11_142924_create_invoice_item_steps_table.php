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
        Schema::create('invoice_item_steps', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');
            $table->string('step_code', 50)->unique();
            $table->string('css_class')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('rank')->default(10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_item_steps');
    }
};
