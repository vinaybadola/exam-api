<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\quizanswer;

class AddAnswerController extends Controller
{
    //
    public function addAnswer(Request $request)
    {
        $validation = Validator::make($request->all(),[
            "option1"=>'required|string',
            "option1"=>'required|string',
            "option1"=>'required|string',
            "option1"=>'required|string',
            "correct_answer"=>'required|string',
            "question_id"=>'required|string',
        ]);

        if($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()->all()]);
        }


        $addanswer = new quizanswer();
        $addanswer->option1=$request->option1;
        $addanswer->option2=$request->option2;
        $addanswer->option3=$request->option3;
        $addanswer->option4=$request->option4;
        $addanswer->correct_answer=$request->correct_answer;
        $addanswer->question_id=$request->question_id;


        if($addanswer->save())
        {
            return response()->json(['message' => 'Answer Added successfully', 'status' => 200]);
        }
        else
        {
            return response()->json(["message" => "Some Error Ocuured"]);
        }

    }
}
