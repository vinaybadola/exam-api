<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\quizquestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getQuestion(Request $request){
        
        $question = $request->subject_quiz_id;
        $getquestion = quizquestion::where("");

    }
}
