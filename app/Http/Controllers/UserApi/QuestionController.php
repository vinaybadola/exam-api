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
        
        $userId = $request->user()->id;
        $question = $request->subject_quiz_id;

        $store = new StudentQuiz();
        $store->marks = "";
        $store->attempt = 0;
        $store->started_at = now();
        $store->finished_at = now();
        $store->user_id = $userId;
        $store->subject_quiz_id = $question;
        if(!$store->save()){
              return response()->json(["Message" => "Some Error Occured", "status" => false]);
        }

        $store->save();

        $getquestion = quizquestion::with('quizAnswers')->where("subject_quiz_id", $question)->limit(1)->get();
        if(!$getquestion){
            return response()->json(["status"=> false, "Message" => "No Question Found on this ID"]);
        }

        return response()->json(["status" => true , "data" => $getquestion]);
                           

    }
}
