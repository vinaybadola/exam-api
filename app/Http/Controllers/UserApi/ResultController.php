<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\QuizResult;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
     public function result(Request $request){
        $response = $request->user()->id; 
        //return $response;
        $studentQuizId = StudentQuiz::where('user_id', $response)->pluck('id')->last();
        $subject_quiz_id = $request->subject_quiz_id;

        $getQuestion = QuizQuestion::where('subject_quiz_id', $subject_quiz_id)->pluck("question_number");
        // return $getQuestion;

        $getResult = QuizQuestionAttempt::where('student_quiz_id', $studentQuizId)->get();
       // return $getResult; 
       $result = [
         'question_id' => 0,
         'correct' => 0,
         'incorrect' => 0,
         'no_attempt' => 0,
     ];
       foreach ($getResult as $attemptedQuestion) {
         $questionId = $attemptedQuestion->question_id;
         
         $answer = QuizAnswer::where('question_id', $questionId)->where('subject_quiz_id', $subject_quiz_id)->first();
         
         if ($answer) {
             if ($attemptedQuestion->selected_ans == $answer->correct_answer) {
                $result['question_id'] = $questionId;
                 $result['correct']++;
             } else {
               $result['question_id'] = $questionId;
                 $result['incorrect']++;
             }
         } else {
            $result['question_id'] = $questionId;
             $result['no_attempt']++;
         }
     }

     return response()->json($result);





                        $correct = 0;
                        $no_attempt= 0;
                        $incorrect = 0;
                        $no_attempt= 0;
                        $result = 0;

                       $result = [];
                        foreach ($getResult as $resp){
                        if($resp->selected_ans == $resp->answer->correct_answer){
                             
                             $correct++;
                            }
                        
                            else if($resp->selected_ans == 0){
                             $no_attempt++;
                            }
                            else{
                               $incorrect++;
                            }
                         }  

                         $result[] = [
                           'correct' => $correct,
                           'in-correct'=> $incorrect,
                           'no-attempt' => $no_attempt,
                       ];

                       // return response()->json($result);
                       

                         $score  = ($correct * 2);
                         if ($score > 2) {
                           $grade = "Pass";
                        } else {
                           $grade = "Fail";
                        }

                        return response()->json(["status" => true, "data" => $result, "total_question"=> $getQuestion, "result" => $grade ]);

                  
                        
                        // $store_quiz = new QuizResult();
                        // $store_quiz->result = $result;
                        // $store_quiz->marks = $grade;
                        // $store_quiz->correct = $correct;
                        // $store_quiz->Incorrect = $incorrect;
                        // $store_quiz->No_Attempt = $no_attempt;
                        // $store_quiz->save();
     }
}
