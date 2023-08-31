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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->text('desc')->nullable();
            $table->boolean('status')->default(true)->comment('0=inactive, 1=active');
            $table->unsignedBigInteger('tleader_id')->unique()->nullable();
            $table->unsignedBigInteger('tagent_id')->nullable();
            $table->unsignedBigInteger('tmanager_id')->nullable();
            $table->timestamps();

            $table->foreign('tleader_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('tagent_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('tmanager_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
