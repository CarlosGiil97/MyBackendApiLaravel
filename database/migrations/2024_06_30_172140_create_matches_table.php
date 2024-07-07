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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id_home')->constrained('teams');
            $table->foreignId('team_id_away')->constrained('teams');
            $table->string('location');
            $table->string('cc');
            $table->date('date');
            $table->foreignId('season_id')->constrained();
            $table->integer('score_home')->nullable();
            $table->integer('score_away')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('teams');
            $table->enum('result', ['home_win', 'away_win', 'draw'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
