<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;
    public function quizQuestion(){
        return $this->belongsTo(QuizQuestion::class , 'quiz_question_id');
    }

    protected $hidden = [
        // 'correct_answer',
        'remember_token',
    ];

    public function attempts()
    {
        return $this->hasMany(QuizQuestionAttempt::class, 'question_id', 'question_id');
    }
}
