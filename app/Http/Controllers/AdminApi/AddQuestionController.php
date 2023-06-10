<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\quizquestion;

class AddQuestionController extends Controller
{
    //
    public function addQuestion(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'question_name' => 'required | string',
            'status'=>"required",
            'level' => 'required',
            'subject_quiz_id'=>'required',
        ]);
        if($validation->fails())
        {
            return response()->json(['errors' => $validation->errors()->all()]);
        }

        $question = new quizquestion();
        $question->question_name=$request->question_name;
        $question->status=$request->status;
        $question->level=$request->level;
        $question->subject_quiz_id=$request->subject_quiz_id;
        if($question->save())
        {

            return response()->json(['message' => 'Question Added successfully', 'status' => 200]);
        }
        else{
            return response()->json(["message" => "Some Error Ocuured"]);
        }

    }
}
