<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAttempt;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;

class NextQuestionController extends Controller
{
    public function getNextQuestion(Request $request)
    {

        $user_id = $request->user()->id;
        $studentQuizId = StudentQuiz::where('user_id', $user_id)->get('id')->last();
        $id =  $studentQuizId->id;
        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
           
            'subject_quiz_id' => 'required',
            'question_type' => 'required|in:Objective,Descriptive'
        ]);

        $option_id = $request->option_id;
        $question_id = $request->question_id;
        $subject_quiz_id = $request->subject_quiz_id;
        $question_type = $request->question_type;


        $quizAttempt = QuizQuestionAttempt::where("question_id", $question_id,)->where("student_quiz_id", $id)->get()->first();
        if ($quizAttempt) {


            $quizAttempt->selected_ans = $option_id;
            $quizAttempt->save();
        } else {


            $storeQuizAttempts = new QuizQuestionAttempt();
            $storeQuizAttempts->selected_ans = $option_id;
            $storeQuizAttempts->student_quiz_id = $id;
            $storeQuizAttempts->question_id = $question_id;
            $storeQuizAttempts->question_type = $question_type;
            if (!$storeQuizAttempts->save()) {
                return response()->json(["Message" => "Some Error Occured", "status" => false]);
            }
            $storeQuizAttempts->save();
        }



        $answer = QuizQuestion::with('quizAnswers')->where('subject_quiz_id', $subject_quiz_id)->whereNotIn('id', function ($q) use ($id) {
            $q->select('question_id')->from('quiz_question_attempts')->where('student_quiz_id', $id);
        })->limit(1)->get();

        $questionCount = quizquestion::where('subject_quiz_id', $subject_quiz_id)->count();

       

        $questions=QuizQuestion::withCount(['attempt'=>function($q)use($id)
        {
            $q->where('student_quiz_id',$id);
        }])->where('subject_quiz_id', $subject_quiz_id)->get();

    
        $response =[];

        foreach($questions as $ques){
            $questionId = $ques->id;
            $attempted = $ques->attempt_count;
            $response[] = [
                'question_id' => $questionId,
                'attempted'=> $attempted, 
            ];

        }


        if ($answer->isEmpty()) {
            return response()->json(["status" => true, "Message" => "Test Over"]);
        }

        return response()->json(["status" => true, "data" => $answer, "attempt"=> $response, "count" => $questionCount]);
    }
}
