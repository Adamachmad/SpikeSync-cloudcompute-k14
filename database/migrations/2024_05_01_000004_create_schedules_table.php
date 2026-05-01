<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->dateTime('scheduled_at')->index();
            $table->string('status')->default('scheduled')->index();
            $table->string('location')->nullable();
            $table->timestamps();
            $table->index(['team_id', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
