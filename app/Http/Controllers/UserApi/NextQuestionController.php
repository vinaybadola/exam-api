<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class NextQuestionController extends Controller
{
    public function getNextQuestion(Request $request){
    $studentQuizId = StudentQuiz::pluck("id")->last();
         //return $studentQuizId;
         $option_id = $request->option_id;
         $question_id = $request->question_id;
         $subject_quiz_id = $request->subject_quiz_id;
         $quizAttempt = QuizQuestionAttempt::where("question_id", $question_id, )->where("student_quiz_id", $studentQuizId)->get()->first();
         if($quizAttempt){
                           $quizAttempt->selected_ans = $option_id;
                           $quizAttempt->save();
                          // return;   
         }
         else{
         $storeQuizAttempts = new QuizQuestionAttempt();
         $storeQuizAttempts->selected_ans = $option_id;
         $storeQuizAttempts->student_quiz_id = $studentQuizId;
         $storeQuizAttempts->question_id = $question_id;
         if(!$storeQuizAttempts->save()){
            return response()->json(["Message" => "Some Error Occured", "status" => false]);
         }
          $storeQuizAttempts->save();
         }

        $answer=QuizQuestion::with('quizAnswers')->where('subject_quiz_id', $subject_quiz_id)->whereNotIn('id',function($q)use($studentQuizId){
            $q->select('question_id')->from('quiz_question_attempts')->where('student_quiz_id',$studentQuizId);
        })->limit(1)->get();

        if($answer->isEmpty()){
            return response()->json(["status"=> true, "Message"=> "Test Over" ]);
        }
        
        return response()->json(["status"=> true, "data"=> $answer ]);
}
}
