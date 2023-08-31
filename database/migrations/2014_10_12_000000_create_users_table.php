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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'manager', 'team_leader', 'agent', 'support_team_leader', 'support_agent'])->default('agent');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('team_leader_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('support_team_leader_id')->nullable();
            $table->unsignedBigInteger('support_agent_id')->nullable();

            $table->foreign('team_leader_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('manager_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('agent_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('support_team_leader_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('support_agent_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
