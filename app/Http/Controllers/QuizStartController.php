<?php

namespace App\Http\Controllers;

use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class QuizStartController extends Controller
{
     public function startQuiz(Request $request){
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

        return response()->json(["status"=> true , "Message" => "Quiz Starts"]);

     }
}

