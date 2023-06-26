<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function updateProfile(Request $request) 
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = $request->user();
        $id = $request->user()->id;
 

        if (!Hash::check($request->get('current_password'), $auth->password)) 
        {
            return response()->json(["status" => false, "Message" => "Old Password doesn't match "]);
        }
 
        if (strcmp($request->get('current_password'), $request->new_password) == 0) 
        {
            return response()->json(["status" => false, "Message" => "New Password cannot be same as your current password."]);
 
        }
 
        $user =  User::find($id);
        $user->password =  Hash::make($request->new_password);
       
        if( $user->save()){
        return response()->json(["status" => true, "Message" => "Password Changes Successfully"]);
        }
        else {
            return response()->json(['error'=>'Something went wrong!']);
        }

    }

}
