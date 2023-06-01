<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request){
        if($request->user()){
            $request->user()->tokens()->delete();
    
        
        }
       return response() ->json(['message' => 'You have been successfully logged out!'], 200);
 }
}
