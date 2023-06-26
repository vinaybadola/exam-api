<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class FinalResultController extends Controller
{

    public function finalResult(Request $request)
    {
        $response = $request->user()->id;
       // return $response;
        $studentQuizId = StudentQuiz::where('user_id', $response)->pluck('id')->last();
        $subject_quiz_id = $request->subject_quiz_id;

        $getQuestion = QuizQuestion::where('subject_quiz_id', $subject_quiz_id)->get("question_number");
        // return $getQuestion;

        $getResult = QuizQuestionAttempt::with('answer')->where('student_quiz_id', $studentQuizId)->get();
       // return $getResult; 

        $questions=QuizQuestion::withCount(['quizQuestionAttempts'=>function($q)use($studentQuizId)
        {
            $q->where('student_quiz_id',$studentQuizId);
        }])->where('subject_quiz_id', $subject_quiz_id)->get()->pluck('quiz_question_attempts_count');
       // return $questions;

        $correct = 0;
        $no_attempt = 0;
        $incorrect = 0;
        $no_attempt = 0;
        $result = 0;

        $result = [];
        foreach ($getResult as $resp) {
            if ($resp->selected_ans == $resp->answer->correct_answer) {

                $correct++;
            } else if ($resp->selected_ans == 0) {
                $no_attempt++;
            } else {
                $incorrect++;
            }
        }

        $result[] = [
            'correct' => $correct,
            'in-correct' => $incorrect,
            'no-attempt' => $no_attempt,
        ];

       // return $result;

        $score  = ($correct * 2);
      
        $totalScore = count($getQuestion);
        $TotalAttempts = count($questions);
        $completionRate = round((  $TotalAttempts/ $totalScore) * 100);


        $correctpercentage = round(($correct/$TotalAttempts)*100);
        $incorrectpercentage=round( ( $incorrect /$TotalAttempts)*100);
        //return $incorrectpercentage;
       
        return response()->json(["status" => true, 
        "data" => $result, 
        "total_question" => $getQuestion, 
        "score" => $score, 
        "completion Rate" => $completionRate ,
        "correctPercentage"=> $correctpercentage,
        "incorrectPercentage" => $incorrectpercentage,
    ]);
    }
}
