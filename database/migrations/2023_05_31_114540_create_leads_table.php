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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('amount')->nullable();
            $table->enum('ftd', [0, 1])->default(0)->comment('no=0, yes=1');
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17])->default(5)->comment(
                '0=follow up,
                1=interested,
                2=not interested,
                3=Existing Customer,
                4=Invalid Number,
                5=new,
                6=switch off,
                7=call busy.
                8=message sent,
                9=no response,
                10=Id created,
                11=sent demo id,
                12=Call after sometimes,
                13=waiting response,
                14=play later,
                15=no payment option,
                16=blocked my number,
                17=declined'
            );
            $table->string('country')->nullable();
            $table->string('source')->nullable();
            $table->string('language')->nullable();
            $table->unsignedBigInteger('lead_agent_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->timestamps();

            $table->foreign('lead_agent_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
