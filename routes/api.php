<?php

use App\Http\Controllers\AdminApi\AdminAccessController;
use App\Http\Controllers\AdminApi\AdminLoginController;
use App\Http\Controllers\AdminApi\UserController;
use App\Http\Controllers\AdminApi\AddController;
use App\Http\Controllers\UserApi\CourseController;
use App\Http\Controllers\UserApi\LoginController;
use App\Http\Controllers\UserApi\LogoutController;
use App\Http\Controllers\UserApi\ProfileController;
use App\Http\Controllers\UserApi\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:passport')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/admin/addCourse',[AddController::class,'addCourse']);
Route::post('/admin/addSubject',[AddController::class,'addSubject']);


Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post("/user/register", [RegisterController::class , 'register']);
    Route::get('/user/profile/{name?}/{id?}', [ProfileController::class, 'showProfile']);
    Route::post("user/login", [LoginController::class , 'login']);
   
   
});

Route::middleware('auth:api')->group(function () {
    Route::post("user/logout", [LogoutController::class, 'logout']);
    Route::post("admin/logout", [AdminAuthController::class, 'Adminlogout']);
    Route::get("/user/courses/all", [CourseController::class, 'userCourses']);
    
   
});


//! ALL Courses related APIs
Route::post("user/courses/all", [CourseController::class, "getCollegeCourses"]);
Route::post("/user/course/subject",[CourseController::class, "getCourseSubjects"]);
Route::post("/user/course/subject/quiz", [CourseController::class, 'getSubjectQuizzes']);





Route::post("admin/login", [AdminLoginController::class, 'adminlogin']);


//!  Add the below api in admin group middleware
Route::get("admin/users/all", [UserController::class, "allUsers"]);


Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user', 'cors', 'json.response']], function(){
             Route::get("/admin/dashboard", [AdminAccessController::class, "showAdminDashboard"]);
});
