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
        Schema::create('tickets', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('secret_message')->nullable();
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('support_id')->nullable();
            $table->unsignedInteger('status_id')->default(1);
            $table->unsignedTinyInteger('department_id')->default(1);
            $table->unsignedTinyInteger('level')->default(1);
            $table->boolean('assign_to_admin')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
