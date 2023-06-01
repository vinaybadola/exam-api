<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function adminlogin(Request $request){
        $validator = Validator::make($request->all(), [
               'email' => 'required|email',
               'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('admin')->attempt(['email'=> request('email'),'password'=> request('password')])){
            config(['auth.guards.api.provider' => 'admin']);
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success = $admin;
            $success['token'] = $admin->createToken('admin',['admin'])->accessToken;

            return response()->json($success,200);

        }
        else {
            return response()->json(['error' => ['Email and password are Wrong']], 422);
        }
    }
}
