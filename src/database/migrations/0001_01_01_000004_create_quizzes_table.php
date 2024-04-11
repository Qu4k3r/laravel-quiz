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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('theme_id');
            $table->foreignUuid('user_id');
            $table->tinyInteger('score')->nullable();
            $table->tinyInteger('total_questions')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();

            $table->foreign('theme_id')->references('id')->on('themes')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
