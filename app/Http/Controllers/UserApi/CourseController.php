<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\CollegeSubject;
use App\Models\course;
use App\Models\SubjectQuiz;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{

  protected function getCollegeCourses(Request $request)
  {
    $clgId = $request->college_id;
    $courses = Course::find($clgId);
    
    if (!$courses ){
      return response()->json([ 'Message' => "Course Not Found", "status" => false]);

     }

     $showCourse = Course::where("college_id", $clgId)->get();

     if($showCourse->isEmpty()) {
        return response()->json(['Message' => "No Courses Found on this id  ", "status" => false]);
       }
      return response()->json([
      "status" => true,
       "data" => $showCourse, 
    ]);
     
    
    
  }

  protected function getCourseSubjects(Request $request)
  {
    $response = $request->user();
    $getCourseId=  $response->course_id;
   
    if(!$getCourseId){
      return response()->json([ 'Message' => "subjects Not Found", "status" => false]);
   
    }
    $courseSubjects = CollegeSubject::where("course_id", $getCourseId)->get();
    $getCoursename = course::where("id", $getCourseId)->pluck("course_name");
    $csname = $getCoursename->toArray();
    if($courseSubjects->isEmpty()) {
      return response()->json(['Message' => "No Subjects Found on this id  ", "status" => false]);
    }
    //return response()->json(["status" => true, "course_name" => $getCoursename,  "data" => $courseSubjects]);
    return response()->json([ "course_name" =>   $csname  , "status"=> true ,  "data" => $courseSubjects ]);

    
  }


  protected function getSubjectQuizzes(Request $request)
  {

    $subjectQuiz = $request->college_subject_id;
    $findSubjectQuiz = SubjectQuiz::find($subjectQuiz);
    // return $findSubjectQuiz;

    if (!$findSubjectQuiz ){
      return response()->json([ 'Message' => "subjects Quizes Not Found", "status" => false]);
    }
      
    $getSubjectQuiz = SubjectQuiz::with('quizdescription')->with('quizInstruction')->where('college_subject_id', $subjectQuiz)->get();

    if($getSubjectQuiz->isEmpty()) {
      return response()->json(['Message' => "No Quizzes Found on this id ", "status" => false ]);
    }
    else{
      return response()->json([
       "status" => true,
       "data" => $getSubjectQuiz, 
    ]);
    }
    
  }
}
