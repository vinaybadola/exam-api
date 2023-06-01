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
        Schema::create('quizresults', function (Blueprint $table) {
            $table->id();
            
 $table->unsignedBigInteger('question_id');
 $table->foreign('question_id')->references('id')->on('quizquestions');
 $table->unsignedBigInteger('user_id');
 $table->foreign('user_id')->references('id')->on('users');
 $table->string('result');
 $table->string('grade');
 $table->string('correct');
 $table->string('in_correct');
 $table->string('no_attempt');
 $table->unsignedBigInteger('subject_quiz_id');
 $table->foreign('subject_quiz_id')->references('id')->on('course_subjects');
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
        Schema::dropIfExists('quizresults');
    }
};
