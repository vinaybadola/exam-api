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
        Schema::create('studentquizzes', function (Blueprint $table) {
            $table->id();     
            $table->string('marks');
            $table->string('attempt');
            $table->dateTime('started_at');
            $table->dateTime('finished_at');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('subject_quiz_id');
            $table->foreign('subject_quiz_id')->references('id')->on('subjectquizzes');
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
        Schema::dropIfExists('studentquizzes');
    }
};
