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
        Schema::create('remineders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->timestamp('event_time');
            $table->enum('is_notified', [0, 1])->default(0)->comment('unseen=0, seen=1');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remineders');
    }
};
