<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectQuiz extends Model
{
    use HasFactory;
    public function quizdescription(){
        return $this->hasOne(QuizDescription::class, "subject_quiz_id");
    }

    public function quizInstruction(){
        return $this->hasOne(QuizInstruction::class, "subject_quiz_id");
    }
}
