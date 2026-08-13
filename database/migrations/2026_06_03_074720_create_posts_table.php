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
        Schema::create('posts', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug', 120)->unique();
            $table->string('meta')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable()->default('/images/image.svg');
            $table->string('thumbnail')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedInteger('views')->default(1);
            $table->unsignedSmallInteger('rank')->default(1);
            $table->boolean('pinned')->default(0);
            $table->boolean('comment')->default(1);
            $table->unsignedSmallInteger('blog_category_id')->nullable();
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
