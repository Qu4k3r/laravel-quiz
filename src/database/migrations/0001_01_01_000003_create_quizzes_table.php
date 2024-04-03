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
        Schema::create('themes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->unique();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('theme_id');
            $table->text('title');

            $table->foreign('theme_id')->references('id')->on('themes')->cascadeOnDelete();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('question_id')->nullable()->index();
            $table->text('text');
            $table->boolean('is_correct')->default(false);

            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->index();
            $table->foreignUuid('theme_id');
            $table->tinyInteger('score')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('theme_id')->references('id')->on('themes')->cascadeOnDelete();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('quizz_id');
            $table->foreignUuid('question_id');
            $table->foreignUuid('answer_id')->nullable();

            $table->foreign('quizz_id')->references('id')->on('quizzes')->cascadeOnDelete();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
            $table->foreign('answer_id')->references('id')->on('options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('options');
        Schema::dropIfExists('themes');
    }
};
