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
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


       
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json(["status" => false, "Message" => "Old Password doesn't match "]);
        }


       
        $user = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(["status" => true, "Message" => "Password Changes Successfully"]);


    }

}
