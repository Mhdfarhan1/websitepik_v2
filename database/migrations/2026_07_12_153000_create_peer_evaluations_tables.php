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
        Schema::create('peer_evaluation_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('peer_evaluation_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->timestamps();
        });

        Schema::create('peer_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('peer_evaluation_schedules')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluatee_id')->constrained('users')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // Evaluator can only evaluate an evaluatee once per schedule
            $table->unique(['schedule_id', 'evaluator_id', 'evaluatee_id'], 'peer_eval_unique');
        });

        Schema::create('peer_evaluation_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('peer_evaluations')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('peer_evaluation_questions')->onDelete('cascade');
            $table->integer('score'); // 1 = Buruk, 2 = Sedang, 3 = Baik, 4 = Sangat Baik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peer_evaluation_scores');
        Schema::dropIfExists('peer_evaluations');
        Schema::dropIfExists('peer_evaluation_questions');
        Schema::dropIfExists('peer_evaluation_schedules');
    }
};
