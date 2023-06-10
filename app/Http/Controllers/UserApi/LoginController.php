<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
     public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors' =>$validator->errors()->all()]);
        }

        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json(["status" => true , "token"=>  'Bearer ' .  $token, "data" => $user]);
               
            }
            else{
                return response()->json(["status" => false,  "message"=> "Password Mismatch"]);
              
            }
        }
        else{
            return response()->json(["status" => false,  "message"=> "User does not exist"]);
            
        }

     }
}
