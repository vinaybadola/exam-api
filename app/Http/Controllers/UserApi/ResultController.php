<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\QuizResult;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;


class ResultController extends Controller
{
  public function result(Request $request)
  {
    $response = $request->user()->id;
    // return $response;
    $studentQuizId = StudentQuiz::where('user_id', $response)->pluck('id')->last();
    //return $studentQuizId;
    $subject_quiz_id = $request->subject_quiz_id;
    // return $subject_quiz_id;
    $getQuestion = QuizQuestion::where('subject_quiz_id', $subject_quiz_id)->pluck('id');
    //return $getQuestion;
    $getResult = QuizQuestionAttempt::where('student_quiz_id', $studentQuizId)->get();
     //return $getResult; 

    $results = [];

    foreach ($getResult as $attemptedQuestion) {
      $questionId = $attemptedQuestion->question_id;

      $answer = QuizAnswer::where('question_id', $questionId)->where('subject_quiz_id', $subject_quiz_id)->first();
       
      $getQuestion = QuizQuestion::where('subject_quiz_id', $subject_quiz_id)->pluck('question_number');
      // return     $getQuestion;

      $result = [
        'question_id' =>  $questionId,
        'correct' => 0,
        'incorrect' => 0,
        'no_attempt' => 0,
      ];

      if ($answer) {
        if ($attemptedQuestion->selected_ans == $answer->correct_answer) {
          $result['correct']++;
        } else {
          $result['incorrect']++;
        }
      } else {
        $result['no_attempt']++;
      }
      $results[] = $result;
    }

   // return $results;

   
    $Response = $results;
    $grade = "";
    $totalCorrect = 0;

    foreach($Response as $right){
      $totalCorrect+= $right['correct'];
    }

   // return $totalCorrect;

    $total = $totalCorrect * 2;
    if($total> 10){
      $grade = "PASS";
    }
    else{
      $grade = "FAIL";
    } 

    if($results){
    return response()->json(["status" => true, "data" => $results, "total_question"=> $getQuestion , "Grade" => $grade ]);
    }
    else{
    return response()->json(['message'=>'No data found']);
    }
  }
}
