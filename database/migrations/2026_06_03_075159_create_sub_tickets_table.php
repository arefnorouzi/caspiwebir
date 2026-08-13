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
        Schema::create('sub_tickets', function (Blueprint $table) {
            $table->mediumIncrements('id')->unsigned();
            $table->string('description')->nullable();
            $table->unsignedMediumInteger('ticket_id');
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->unsignedMediumInteger('support_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tickets');
    }
};
