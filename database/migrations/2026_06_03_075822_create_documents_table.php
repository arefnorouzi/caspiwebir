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
        Schema::create('documents', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->unsignedMediumInteger('user_id');
            $table->unsignedMediumInteger('invoice_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('note')->nullable();
            $table->string('document_path')->nullable();
            $table->unsignedTinyInteger('document_type_id')->default(1);
            $table->unsignedTinyInteger('document_status_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
