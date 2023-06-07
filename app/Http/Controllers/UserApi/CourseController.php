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
    $courses  = Course::find($clgId);
    $getCourses = $courses->course_name;
    if (!empty($getCourses) ){
      return response()->json([$courses, 'Message' => "Success", "status" => true]);

     }
     else  {
      return response()->json(['Message' => "No Courses Found ", "status" => false]);
    }
   
  }



  protected function getCourseSubjects(Request $request)
  {
    $subject = $request->course_id;
    $getSubject = CollegeSubject::where('course_id', $subject)->get('subject_name');
    if ($getSubject) {
      return response()->json([$getSubject, 'Message' => "Success", "status" => true]);
    } else {
      return response()->json(['Message' => "No subject Found ", "status" => false]);
    }
  }



  protected function getSubjectQuizzes(Request $request)
  {

    $subjectquiz = $request->college_subject_id;
    $getSubjectQuiz = SubjectQuiz::where('subject_quiz_id', $subjectquiz)->get("subject_quiz_name");

    if ($getSubjectQuiz) {
      return response()->json([$getSubjectQuiz, 'Message' => "Success", "status" => 200]);
    } else {
      return response()->json(['Message' => "No subject Quiz Found ", "status" => 400]);
    }
  }
}
