<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Model
{
    use HasFactory;
    public function quizQuestionattempt(){
        return $this->hasMany(QuizQuestionAttempt::class,'student_quiz_id');
    }
}
