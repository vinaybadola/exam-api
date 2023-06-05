<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\coursequiz;
use App\Models\courseSubject;
use App\Models\SubjectQuiz;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
     public function userCourses(){
        $courses  = course::all();
        if($courses){
        return response()->json([$courses, 'Message' => "Success", "status" => 200]);
        }
        else{
         return response()->json(['Message' => "No Courses Found ", "status" => 400]);
        }
     }

     public function getcoursequizzes(Request $request){
        $subject = $request->course_id;
        $getSubject = courseSubject::where('course_id', $subject)->get('subject_name');
        if($getSubject){
         return response()->json([$getSubject, 'Message' => "Success", "status" => 200]);
        }
        else {
            return response()->json(['Message' => "No subject Found ", "status" => 400]);
        }
     }


    
     public function getSubjectQuizzes(Request $request){

          $subjectquiz = $request->subject_quiz_id;
          $getSubjectQuiz = SubjectQuiz::where('subject_quiz_id', $subjectquiz)->get("course_quiz_name");
       
          if($getSubjectQuiz){
            return response()->json([$getSubjectQuiz, 'Message' => "Success", "status" => 200]);
          }
          else{
            return response()->json(['Message' => "No subject Quiz Found ", "status" => 400]);

          }
     }

     
     

}


