<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizDescription extends Model
{
    use HasFactory;
    public function subjectQuiz(){
        return $this->hasOne(SubjectQuiz::class , "subject_quiz_id");

    }
}
