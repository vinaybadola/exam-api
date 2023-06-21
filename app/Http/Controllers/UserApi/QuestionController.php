<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizDescription;
use App\Models\quizquestion;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;


class QuestionController extends Controller
{
    public function getQuestion(Request $request){  
        $subjectQuizId = $request->subject_quiz_id;
        $getquestion = quizquestion::with('quizAnswers')->where("subject_quiz_id", $subjectQuizId)->limit(1)->get();
        $questionCount = quizquestion::where('subject_quiz_id', $subjectQuizId )->count();
      
      
       
        if(!$getquestion){
            return response()->json(["status"=> false, "Message" => "No Question Found on this ID"]);
        }

        return response()->json(["status" => true , "data" => $getquestion, "count" => $questionCount]);
                           

    }
}
