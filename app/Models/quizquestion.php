<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    public function quizAnswers(){
        return $this->hasMany(QuizAnswer::class , 'question_id');
    }

    public function quizQuestionAttempts(){
        return $this->belongsToMany(QuizQuestionAttempt::class , 'question_id');
    }

    public function attempt()
    {
        return $this->hasMany(QuizQuestionAttempt::class , 'question_id');
    }

   
}
