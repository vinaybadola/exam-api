<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Courses;
use App\Models\Subject;
use App\Models\SubjectQuiz;
use Illuminate\Support\Facades\Validator;


class AddController extends Controller
{
    //
    public function addCourse(Request $request)
    {
        
        $validation=Validator::make($request->all(),[
            'course_name' =>'required|unique:courses,course_name',
        ]);

        if($validation->fails())
        {
            return response()->json(['errors' => $validation->errors()->all()]);
        }
        
        $course=new Course();
        $course->course_name=$request->course_name;

        if($course->save())
        {

            return response()->json(['message' => 'course Added successfully', 'status' => 200]);
        }
        else{
            return response()->json(["message" => "Some Error Ocuured"]);
        }
    }



    public function addSubject(Request $request)
    {
        
        $validation=Validator::make($request->all(),[
            'subject_name' =>'required|unique:subjects,subject_name',
            'course_id'=> 'required'
        ]);

        if($validation->fails())
        {
            return response()->json(['errors' => $validation->errors()->all()]);
        }
        
        $subject=new SubjectQuiz();
        $subject->subject_name=$request->subject_name;
        $subject->course_id=$request->course_id;

        if($subject->save())
        {

            return response()->json(['message' => 'Subject Added successfully', 'status' => 200]);
        }
        else{
            return response()->json(["message" => "Some Error Ocuured"]);
        }
    }


    public function addSubjectQuiz(Request $request)
    {
        
    }
}
