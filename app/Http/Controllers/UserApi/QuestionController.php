<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizDescription;
use App\Models\quizquestion;
use Illuminate\Http\Request;


class QuestionController extends Controller
{
    public function getQuestion(Request $request){
        
        $subjectQuizId = $request->subject_quiz_id;

        $getquestion = quizquestion::with('quizAnswers')->where("subject_quiz_id", $subjectQuizId)->limit(1)->get();
        $getDescription = QuizDescription::where("subject_quiz_id", $subjectQuizId)->get();
        return response()->json(["status" => true , "data" => $getquestion]);
                           

    }
}
