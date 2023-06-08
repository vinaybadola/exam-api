<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Course;

class AddCourseController extends Controller
{
    //
    public function addCourse(Request $request)
    {
        $validation = Validator::make($request->all(),[
           'course_name'=>'required|string|unique:courses,course_name',
           'college_id' => 'required'
        ]);

        if($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()->all()]);
        }


        $addcourse = new Course();
        $addcourse->addcourse=$request->addcourse;
        $addcourse->college_id=$request->college_id;


        if($addcourse->save())
        {
            return response()->json(['message' => 'College Added successfully', 'status' => 200]);
        }
        else
        {
            return response()->json(["message" => "Some Error Ocuured"]);
        }

    }
}
