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
        Schema::create('comments', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->morphs('commentable');
            $table->string('description')->nullable();
            $table->string('support_reply')->nullable();
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('support_id')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
