<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
            'date_of_birth' => 'required|string',
            'contact'=> 'required',
            'alternate_contact' => 'integer',
            'status', 
            'course_id'=> 'required',
            'college_id'=> 'required'
            
            


        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make( $request->password);
        $user->date_of_birth = $request->date_of_birth;
        $user->contact = $request->contact;
        $user->alternate_contact = $request->alternate_contact;
        $user->status  = $request->status;
        $user->course_id = $request->course_id;
        $user->college_id = $request->college_id;
        $user->remember_token = Str::random(10);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        if($user->save()){
            $response = ['token' => $token];
            return response()->json([ $response, 'message' => 'success', 'status' => 200]);
        }
        else{
            return response()->json(["message" => "Some Error Ocuured"]);
        }


      
   
      
    }
}
