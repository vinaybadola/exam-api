<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class FetchParticularQuestion extends Controller
{
     public function fetchparticularQuestion(Request $request){
        $user_id = $request->user()->id;
        $questionId = $request->question_id;
        $subject_quiz_id = $request->subject_quiz_id;
        $studentQuizId = StudentQuiz::where('user_id', $user_id)->get('id')->last();
        $id =  $studentQuizId->id;


        $questionCount = quizquestion::where('subject_quiz_id', $subject_quiz_id )->count();

        $questions=QuizQuestion::withCount(['attempt'=>function($q)use($id)
        {
            $q->where('student_quiz_id',$id);
        }])->where('subject_quiz_id', $subject_quiz_id)->get();


        $response =[];

        foreach($questions as $ques){
            $questionId = $ques->id;
            $attempted = $ques->attempt_count;
            $question_number = $ques->question_number;
            $response[] = [
                'question_id' => $questionId,
                'attempted'=> $attempted, 
                'question_number'=> $question_number,
            ];

        }

        $getQuestion = QuizQuestion::where('id', $questionId)->with('quizAnswers')->where('subject_quiz_id', $subject_quiz_id)->get();
       // return $getQuestion;
     


        if( !$getQuestion){
            return response()->json(["status"=> false, "Message"=> "questions not Found" ]);
            
        }

        if($getQuestion->isEmpty()){
            return response()->json(["status"=> false, "Message"=> "questions not Found" ]);
        }


        return response()->json(["status"=> true, "data"=> $getQuestion ,"count"=> $questionCount ,  "attempt"=> $response,]);
     }
}
