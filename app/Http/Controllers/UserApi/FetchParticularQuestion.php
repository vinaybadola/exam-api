<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use Illuminate\Http\Request;

class FetchParticularQuestion extends Controller
{
     public function fetchparticularQuestion(Request $request){
        $questionId = $request->question_id;
        $subject_quiz_id = $request->subject_quiz_id;
        $questionCount = quizquestion::where('subject_quiz_id', $subject_quiz_id )->count();
        $getQuestion = QuizQuestion::where('id', $questionId)->with('quizAnswers')->where('subject_quiz_id', $subject_quiz_id)->get();
        
        if( !$getQuestion){
            return response()->json(["status"=> false, "Message"=> "questions not Found" ]);
            
        }

        if($getQuestion->isEmpty()){
            return response()->json(["status"=> false, "Message"=> "questions not Found" ]);
        }


        return response()->json(["status"=> true, "data"=> $getQuestion ,"count"=> $questionCount ]);
     }
}
