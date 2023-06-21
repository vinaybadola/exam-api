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
        $studentQuizId = StudentQuiz::where('user_id', $response)->get('id')->last();
        $id =  $studentQuizId->id;
        //return $id;
        $subject_quiz_id = $request->subject_quiz_id;

        $getQuestion = QuizQuestion::where('subject_quiz_id', $subject_quiz_id)->get("question_number");

        $response = DB::table('quiz_question_attempts')
                        ->join('quiz_answers', 'quiz_question_attempts.question_id', '=', 'quiz_answers.question_id')
                        ->where('quiz_question_attempts.student_quiz_id', $id)
                        ->select('quiz_question_attempts.selected_ans', 'quiz_answers.correct_answer')
                        ->get();

                       // return $response;



                        $correct = 0;
                        $no_attempt= 0;
                        $incorrect = 0;
                        $no_attempt= 0;
                        $result = 0;

                   
                       $result = [];
                        foreach ($response as $resp){
                            if($resp->selected_ans == $resp->correct_answer){
                           
                             $correct++;
                            }
                        
                            else if($resp->selected_ans == 0){
                             $no_attempt++;
                            }
                            else{
                               $incorrect++;
                            }
                            $result[] = [
                              'correct' => $correct,
                              'in-correct'=> $incorrect,
                              'no-attempt' => $no_attempt,
                          ];
             
                         }  

                         return response()->json($result);

                         $result  = ($correct * 2);
                         if ($result > 2) {
                           $grade = "Pass";
                        } else {
                           $grade = "Fail";
                        }

                  
                        
                        $store_quiz = new QuizResult();
                        $store_quiz->result = $result;
                        $store_quiz->marks = $grade;
                        $store_quiz->correct = $correct;
                        $store_quiz->Incorrect = $incorrect;
                        $store_quiz->No_Attempt = $no_attempt;
                        $store_quiz->save();
     }
}
