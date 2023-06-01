<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\coursequiz;
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
        $getSubject = coursequiz::where('course_id', $subject)->get('course_quiz_name');
        if($getSubject){
         return response()->json([$getSubject, 'Message' => "Success", "status" => 200]);
        }
        else {
            return response()->json(['Message' => "No Quiz Found ", "status" => 400]);
        }
     }

     public function getSubjectQuizzes(Request $request){
          
     }

}


