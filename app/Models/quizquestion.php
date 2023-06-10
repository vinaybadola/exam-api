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

   
}
