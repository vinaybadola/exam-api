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
        Schema::create('quiz_instructions', function (Blueprint $table) {
            $table->id();
            $table->string("instructions")->default(0);
            $table->unsignedBigInteger("subject_quiz_id");
            $table->foreign("subject_quiz_id")->references("id")->on("subject_quizzes");
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
        Schema::dropIfExists('quiz_instructions');
    }
};
