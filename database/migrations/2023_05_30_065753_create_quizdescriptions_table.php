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
        Schema::create('quizdescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('quizdescription');
            $table->unsignedBigInteger('course_quiz_id');
            $table->foreign('course_quiz_id')->references('id')->on('coursequizzes');
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
        Schema::dropIfExists('quizdescriptions');
    }
};
