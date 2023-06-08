<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\CollegeName;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function getCollegeName(){
        $clgName = CollegeName::all();
        if($clgName->isEmpty()){
            return response()->json(["status"=> false, "Message" => "No College Found"]);
        }
        return response()->json([
            "message" =>  'ok',
             "data" => $clgName

        ]);
    }
}
