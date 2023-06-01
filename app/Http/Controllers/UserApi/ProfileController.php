<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile(Request $request){
        $response = User::where('firstname', $request->name)->first();
        if($response){
            return response()->json(['success' => true, 'data' => $response, 'status' => 200]);
        }
        else{
            return response()->json(['success'=> false, 'Message'=> 'User Not found try with your only First Name']);
        }
    }

    public function updateProfile(){
        
    }

    
}
