<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('rank')->index();
            $table->unsignedInteger('total_points')->default(0)->index();
            $table->unsignedInteger('total_spikes')->default(0);
            $table->unsignedInteger('total_blocks')->default(0);
            $table->unsignedInteger('total_aces')->default(0);
            $table->timestamps();
            $table->unique(['team_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
