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
        Schema::create('page_sections', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('meta')->nullable();
            $table->string('type')->default(\App\Enums\PageSectionType::TEXT->value);
            $table->json('settings')->nullable(); // تنظیمات اختصاصی هر سکشن
            $table->unsignedTinyInteger('columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('xl_columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('lg_columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('md_columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('sm_columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('xs_columns')->default(1); // 1 | 2 | 3
            $table->unsignedTinyInteger('gap')->default(1);
            $table->unsignedTinyInteger('margin_top')->default(0);
            $table->unsignedTinyInteger('margin_bottom')->default(0);
            $table->unsignedTinyInteger('margin_right')->default(0);
            $table->unsignedTinyInteger('margin_left')->default(0);
            $table->unsignedTinyInteger('padding_top')->default(0);
            $table->unsignedTinyInteger('padding_bottom')->default(0);
            $table->unsignedTinyInteger('padding_right')->default(0);
            $table->unsignedTinyInteger('padding_left')->default(0);
            $table->unsignedTinyInteger('rank')->default(0);
            $table->unsignedTinyInteger('position')->default(0);
            $table->string('background_color')->nullable()->default('#ffffff');
            $table->string('text_color')->nullable()->default('#212121');
            $table->boolean('status')->default(true);
            $table->boolean('show_name')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
