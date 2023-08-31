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
        Schema::create('break_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attend_id');
            $table->timestamp('break_in')->nullable();
            $table->timestamp('break_out')->nullable();
            $table->timestamps();

            $table->foreign('attend_id')->references('id')->on('attendances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('break_entries');
    }
};
