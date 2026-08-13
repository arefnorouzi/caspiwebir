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
        Schema::create('document_types', function (Blueprint $table) {
            $table->tinyIncrements('id')->unsigned();
            $table->string('name');
            $table->string('code', 30);
            $table->boolean('status')->default(true);
            $table->string('description')->nullable();
            $table->boolean('social_networks')->default(0);
            $table->unsignedMediumInteger('max_size')->default(512);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
