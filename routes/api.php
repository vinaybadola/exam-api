<?php

use App\Http\Controllers\AdminApi\AdminAccessController;
use App\Http\Controllers\AdminApi\AdminLoginController;
use App\Http\Controllers\AdminApi\UserController;
use App\Http\Controllers\AdminApi\AddCollegeController;
use App\Http\Controllers\AdminApi\AddController;
use App\Http\Controllers\UserApi\CollegeController;
use App\Http\Controllers\UserApi\CourseController;
use App\Http\Controllers\UserApi\LoginController;
use App\Http\Controllers\UserApi\LogoutController;
use App\Http\Controllers\UserApi\NextQuestionController;
use App\Http\Controllers\UserApi\ProfileController;
use App\Http\Controllers\UserApi\QuestionController;
use App\Http\Controllers\UserApi\RegisterController;
use App\Http\Controllers\UserApi\UpdateProfileController;
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

Route::middleware('auth:api')->get('/user',  [ProfileController::class, "getprofile"]);
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', [ProfileController::class, "getprofile"]);
    Route::post("/user/course/subject",[CourseController::class, "getCourseSubjects"]);
    Route::post("/user/course/subject/quiz", [CourseController::class, 'getSubjectQuizzes']);
    Route::post("/users/questions/all", [QuestionController::class, "getQuestion"]);
    Route::post("/users/fetch-next-question", [NextQuestionController::class, "getNextQuestion"]);
    
});




Route::post('/admin/addCollege',[AddCollegeController::class,'addCollege']);
Route::get('/admin/getCollege',[AddCollegeController::class,'getCollege']);


Route::post('/admin/addCourse',[AddController::class,'addCourse']);
Route::post('/admin/addSubject',[AddController::class,'addSubject']);

Route::post('/admin/addSubjectQuiz',[AddController::class,'addSubjectQuiz']);

Route::post('/admin/addQuestion',[AddQuestionController::class,'addQuestion']);
Route::post('/admin/addAnswer',[AddAnswerController::class,'addAnswer']);

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post("/user/register", [RegisterController::class , 'register']);
    Route::get('/user/profile/{name?}/{id?}', [ProfileController::class, 'showProfile']);
    Route::post("user/login", [LoginController::class , 'login']);
   
   
});

Route::middleware('auth:api')->group(function () {
    Route::post("user/logout", [LogoutController::class, 'logout']);
    Route::post("admin/logout", [AdminAuthController::class, 'Adminlogout']);
    Route::get("/user/courses/all", [CourseController::class, 'userCourses']);
    Route::post("/user/profile/update", [UpdateProfileController::class, "updateProfile"]);
    
   
});


//! ALL Courses related APIs
Route::get("user/colleges/all", [CollegeController::class, "getCollegeName"]);
Route::post("user/courses/all", [CourseController::class, "getCollegeCourses"]);






//Route::post("/user/course/subject/quiz/questions", [QuestionController::class, "getQuestion"]);


//!  Add the below api in admin group middleware



Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user', 'cors', 'json.response']], function(){
             Route::get("/admin/dashboard", [AdminAccessController::class, "showAdminDashboard"]);
});
