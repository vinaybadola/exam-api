<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
Use App\Models\CollegeName;

class AddCollegeController extends Controller
{
    //

    public function addCollege(Request $request)
    {
        $validation = Validator::make($request->all(),[
           'college_name'=>'required|string|unique:college_names,college_name',
        ]);

        if($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()->all()]);
        }


        $addcollege = new CollegeName();
        $addcollege->college_name=$request->college_name;

        if($addcollege->save())
        {
            return response()->json(['message' => 'College Added successfully', 'status' => 200]);
        }
        else
        {
            return response()->json(["message" => "Some Error Ocuured"]);
        }

    }



    public function getCollege(Request $request){

        // $college=$request->college_name;
        // $collegeName=CollegeName::where("college_name", $college)->get('college_name');

       $college=CollegeName::all();
     
        if($college){
          return response()->json([$college, 'Message' => "Success", "status" => 200]);
        }
        else{
          return response()->json(['Message' => "No subject Quiz Found ", "status" => 400]);

        }
   }
}
