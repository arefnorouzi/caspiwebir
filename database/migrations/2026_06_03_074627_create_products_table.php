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
        Schema::create('products', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('product_old_id')->nullable();
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_meta')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_tags')->nullable();
            $table->string('sku')->nullable();
            $table->string('model')->nullable();
            $table->string('slug', 180)->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('offer_price')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->unsignedSmallInteger('stock')->default(1);
            $table->unsignedSmallInteger('min_buy')->default(1);
            $table->unsignedMediumInteger('sales')->default(0);
            $table->unsignedInteger('views')->default(1);
            $table->unsignedSmallInteger('rank')->default(1);
            $table->string('guarantee')->nullable();
            $table->string('warranty')->nullable();
            $table->string('meta')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable()->default('/images/image.svg');
            $table->boolean('is_variant')->default(0);
            $table->boolean('home_page')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('pinned')->default(0);
            $table->boolean('comment')->default(1);
            $table->boolean('amazing')->default(0);
            $table->boolean('suggested')->default(0);
            $table->boolean('golden')->default(0);
            $table->boolean('downloadable')->default(0);
            $table->boolean('software')->default(0);
            $table->boolean('source')->default(0);
            $table->string('course_time')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->string('note')->nullable();
            $table->boolean('buyable')->default(1);
            $table->boolean('pre_order')->default(0);
            $table->boolean('installment_purchase')->default(1);
            $table->unsignedMediumInteger('product_width')->nullable();
            $table->unsignedMediumInteger('product_height')->nullable();
            $table->unsignedMediumInteger('product_lenght')->nullable();
            $table->unsignedMediumInteger('product_weight')->nullable();
            $table->boolean('need_box')->default(0); // نیاز به بسته بندی برای ارسال دارد یا خیر؟
            $table->boolean('huge_box')->default(0); // نیاز به بسته بندی برای ارسال دارد یا خیر؟
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('brand_id')->nullable();
            $table->unsignedMediumInteger('product_unit_id')->default(1)->nullable();
            $table->unsignedMediumInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('video')->nullable();
            $table->string('podcast')->nullable();
            $table->text('excerpt_review')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('category_id');
            $table->unsignedMediumInteger('product_id');
            $table->timestamps();
            $table->unique(['category_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
    }
};
