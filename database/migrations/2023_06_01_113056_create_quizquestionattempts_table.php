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
        Schema::create('quizquestionattempts', function (Blueprint $table) {
            $table->id();
            $table->string('selected_ans');
            $table->unsignedBigInteger('student_quiz_id');
            $table->foreign('student_quiz_id')->references('id')->on('studentquizzes');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('quizquestions');
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
        Schema::dropIfExists('quizquestionattempts');
    }
};
