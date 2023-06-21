<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\QuizQuestionDescriptive;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class NextQuestionController extends Controller
{
    public function getNextQuestion(Request $request){

         $user_id = $request->user()->id; 
         //return $user_id;
         $studentQuizId = StudentQuiz::where('user_id', $user_id)->get('id')->last();
         $id =  $studentQuizId->id;
        // return $id;
         $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'option_id' => 'required',
            'subject_quiz_id'=> 'required',
            'question_type' => 'required|in:Objective,Descriptive'
        ]);


         $option_id = $request->option_id;
         $question_id = $request->question_id;
         $subject_quiz_id = $request->subject_quiz_id;
         $question_type = $request->question_type;

        // return $question_type;
       
         if($question_type === 'Objective'){
           // return "ok";


         $quizAttempt = QuizQuestionAttempt::where("question_id", $question_id, )->where("student_quiz_id", $id)->get()->first();
        // return $quizAttempt;
         if($quizAttempt ){
            
        //  return "ok";
                           $quizAttempt->selected_ans = $option_id;
                           $quizAttempt->save();
                          // return "ok";
                          
         }
         else{

           // return "ok";
           
         $storeQuizAttempts = new QuizQuestionAttempt();
         $storeQuizAttempts->selected_ans = $option_id;
         $storeQuizAttempts->student_quiz_id = $id;
         $storeQuizAttempts->question_id = $question_id;
         if(!$storeQuizAttempts->save()){
            return response()->json(["Message" => "Some Error Occured", "status" => false]);
         }
          $storeQuizAttempts->save();
         }
         $answer=QuizQuestion::with('quizAnswers')->where('question_type', $question_type)->where('subject_quiz_id', $subject_quiz_id)->whereNotIn('id',function($q)use($id){
            $q->select('question_id')->from('quiz_question_attempts')->where('student_quiz_id',$id);
        })->limit(1)->get();

      
    }
        
        elseif($question_type === 'Descriptive'){
           // return "ok";
            $quizAttemptDesc = QuizQuestionDescriptive::where("question_id", $question_id, )->where("student_quiz_id", $id)->get()->first();
            //return $quizAttemptDesc;
            
            if($quizAttemptDesc){
                $quizAttemptDesc->user_ans = $option_id;
                $quizAttemptDesc->save();

            }
            else{

            $storeDescAnswer = new QuizQuestionDescriptive();
            $storeDescAnswer->user_ans = $option_id;
            $storeDescAnswer->question_id = $question_id;
            $storeDescAnswer->user_id = $user_id;
            $storeDescAnswer->subject_quiz_id = $subject_quiz_id;
            $storeDescAnswer->student_quiz_id = $id;
            if(!$storeDescAnswer->save()){
                return response()->json(["Message" => "Some Error Occured", "status" => false]);
             }
              $storeDescAnswer->save();
             }
             $answer=QuizQuestion::with('quizAnswers')->where('question_type', $question_type)->where('subject_quiz_id', $subject_quiz_id)->whereNotIn('id',function($q)use($id){
                $q->select('question_id')->from('quiz_question_descriptives')->where('student_quiz_id',$id);
            })->limit(1)->get();

            
        }
             
           

       
            
       
        
        $questionCount = quizquestion::where('subject_quiz_id', $subject_quiz_id )->count();


        if($answer->isEmpty()){
            return response()->json(["status"=> true, "Message"=> "Test Over" ]);
        }
        
        return response()->json(["status"=> true, "data"=> $answer , "count"=> $questionCount ]);
    }
}

