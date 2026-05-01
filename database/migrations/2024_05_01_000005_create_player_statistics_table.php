<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('match_id')->nullable();
            $table->unsignedInteger('spike_count')->default(0);
            $table->unsignedInteger('block_count')->default(0);
            $table->unsignedInteger('ace_count')->default(0);
            $table->float('pass_accuracy')->default(0);
            $table->unsignedInteger('set_count')->default(0);
            $table->unsignedInteger('dig_count')->default(0);
            $table->timestamps();
            $table->index(['player_id', 'created_at']);
            $table->index(['team_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_statistics');
    }
};
