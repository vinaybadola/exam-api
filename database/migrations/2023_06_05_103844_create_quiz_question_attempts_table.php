<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_question_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('selected_ans');
            $table->unsignedBigInteger('student_quiz_id');
            $table->foreign('student_quiz_id')->references('id')->on('student_quizzes');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('quiz_questions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_question_attempts');
    }
};
