<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class TestController extends Controller
{
    public function getAttemptedQuestion(Request $request){
        $response = $request->user()->id; 
        $studentQuizId = StudentQuiz::where('user_id', $response)->get('id')->last();
        $id =  $studentQuizId->id;

        $request->validate([
            'subject_quiz_id' => 'required',
        ]);

        $subjectQuizId = $request->subject_quiz_id;
        $questions=QuizQuestion::withCount(['attempt'=>function($q)use($id)
        {
            $q->where('student_quiz_id',$id);
        }])->where('subject_quiz_id', $subjectQuizId)->get();


        return $questions;

         

        $response =[];

        foreach($questions as $ques){
            $questionId = $ques->id;
            $attempted = $ques->attempt_count;
            $response[] = [
                'question_id' => $questionId,
                'attempted'=> $attempted, 
            ];

        }
        return response()->json($response);

      

        // $getQuestionWithSelectedAns = DB::table('quiz_question_attempts')->addSelect())->
        // ->join('quiz_questions','quiz_question_attempts.question_id','=','quiz_questions.id')
        // ->select('quiz_question_attempts.selected_ans','quiz_questions.id')
        // ->where('quiz_question_attempts.student_quiz_id','=', $id )
        // ->get();

                       
        // quiz_question_attempt::with('quiz_questions')->where('quiz_id','$id')->get();
        //return $getQuestionWithSelectedAns;

     



    //             $getQuestionWithSelectedAns = DB::table('quiz_question_attempts')
    //             ->join('quiz_questions', 'quiz_question_attempts.question_id', '=', 'quiz_questions.id')
    //             ->leftJoin('quiz_question_descriptives', 'quiz_questions.id', '=', 'quiz_question_descriptives.question_id')
    //             ->select('quiz_question_attempts.selected_ans', 'quiz_questions.id', 'quiz_question_descriptives.user_ans', 'quiz_question_descriptives.question_id')
    //             ->where('quiz_question_attempts.student_quiz_id', '=', $id)
    //             ->get();


    //   return $getQuestionWithSelectedAns;

    //    $response = [];
        
    //     foreach ($getQuestion as $question) {
    //         $questionId = $question['id'];
    //         $attempted = $this->checkIfQuestionAttempted($getQuestionWithSelectedAns); 
          
    //         $response[] = [
    //             'question_id' => $questionId,
    //             'attempted' => $attempted ? 1 : 0,
    //         ];
    //     }
        
    //     return response()->json($response);
    }

}
