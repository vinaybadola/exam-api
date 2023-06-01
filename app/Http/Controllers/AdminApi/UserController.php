<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allUsers(){
        $user  = User::all();
        return response() ->json([$user, 'Message' => "Success", "status" => 200]);
     }
}
