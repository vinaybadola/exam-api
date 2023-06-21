<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getAttemptedQuestion(Request $request){
        $response = $request->user()->id; 
        //return $response;
        $studentQuizId = StudentQuiz::where('user_id', $response)->get('id')->last();
        $id =  $studentQuizId->id;
       //return $id;
        $subjectQuizId = $request->subject_quiz_id;
        $getQuestion = QuizQuestion::where('subject_quiz_id', $subjectQuizId)->get();
        //return $getQuestion;
        $getQuestionWithSelectedAns = DB::table('quiz_question_attempts')
        ->join('quiz_questions','quiz_question_attempts.question_id','=','quiz_questions.id')
        ->select('quiz_question_attempts.selected_ans','quiz_questions.id')
        ->where('quiz_question_attempts.student_quiz_id','=', $id )
        ->get();

       //return $getQuestionWithSelectedAns;

       $response = [];
        
        foreach ($getQuestion as $question) {
            $questionId = $question['id'];
            $attempted = $this->checkIfQuestionAttempted($getQuestionWithSelectedAns); 
          
            $response[] = [
                'question_id' => $questionId,
                'attempted' => $attempted ? 1 : 0,
            ];
        }
        
        return response()->json($response);
    }

     public  function checkIfQuestionAttempted($getQuestionWithSelectedAns ){
        if (isset($getQuestionWithSelectedAns['selected_ans']) && $getQuestionWithSelectedAns['selected_ans'] !== 0) {
            return true;
        }
    
        return false;
    
    }
}
