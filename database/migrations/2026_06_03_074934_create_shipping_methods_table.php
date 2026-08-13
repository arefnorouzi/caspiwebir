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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');           // مثلا "پست پیشتاز"، "تیپاکس"، "پیک"
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->string('code')->unique(); // express, standard, courier
            $table->unsignedInteger('base_cost')->default(0); // هزینه پایه حمل
            $table->unsignedInteger('weight_cost')->default(0); // قیمت هر کیلو
            $table->unsignedInteger('price_adjustment')->nullable();
            $table->unsignedInteger('box_cost')->default(0); // هزینه بسته بندی
            $table->unsignedMediumInteger('normal_weight')->nullable(); // geram
            $table->unsignedMediumInteger('normal_lenght')->nullable(); //cm
            $table->unsignedMediumInteger('normal_width')->nullable(); //cm
            $table->unsignedMediumInteger('normal_height')->nullable(); //cm
            $table->unsignedInteger('free_order_amount')->nullable();
            $table->unsignedInteger('max_cost')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('province_id')->nullable(); // shop province
            $table->string('city')->nullable(); // shop city
            $table->boolean('status')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
