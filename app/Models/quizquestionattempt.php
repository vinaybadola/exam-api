<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionAttempt extends Model
{
    use HasFactory;
    public function studentquiz(){
        return $this->belongsTo(StudentQuiz::class, "student_quiz_id");
    }

    public function quizQuestion(){
        return $this->hasMany(QuizQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(QuizAnswer::class, 'question_id', 'question_id');
    }
}
