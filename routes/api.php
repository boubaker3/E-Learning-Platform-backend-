<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SubsController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\SavesController;
use App\Http\Controllers\WatchedController;
use App\Http\Controllers\PurshasesController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post("signup ",[AuthController::class,"register"]);
Route::post("login ",[AuthController::class,"login"]);
Route::get("search ",[CoursesController::class,"search"]);
Route::get("mostPopularCourses",[CoursesController::class,"recommendedCourses"]);

Route::middleware([ 'jwt_verify' 
])->group(function () {
    

    Route::post("sharecourse ",[CoursesController::class,"sharecourse"]);
    Route::post("updateProfile ",[AuthController::class,"updateProfile"]);
    Route::post("updatePhoto ",[ProfileController::class,"updatePhoto"]);
    Route::post("postReview ",[RatingController::class,"postReview"]);
    Route::post("addToCart ",[CartController::class,"addToCart"]);
    Route::post("follow ",[SubsController::class,"follow"]);
    Route::post("save ",[SavesController::class,"save"]);
    Route::post("watched ",[WatchedController::class,"addWatched"]);
    Route::post("purshase ",[PurshasesController::class,"purshase"]); 
    Route::post("validatePayment ",[PurshasesController::class,"validatePayment"]);
    
    Route::get("userdata ",[ProfileController::class,"getUserdata"]);
    Route::get("profileCourses ",[CoursesController::class,"getProfileCourses"]);
    Route::get("courseDetails ",[CoursesController::class,"getCourseDetails"]);
    Route::get("viewVideo ",[CoursesController::class,"viewVideo"]);
    Route::get("showReviews ",[RatingController::class,"showReviews"]);
    Route::get("cartCourses ",[CartController::class,"getCartCourses"]);
    Route::get("recommendedCourses ",[CoursesController::class,"recommendedCourses"]);
    Route::get("showNotifications ",[NotifController::class,"showNotifications"]);
    Route::get("addedCartCourses ",[CartController::class,"getAddedCartCourses"]);
    Route::get("followingCourses",[SubsController::class,"getFollowingCourses"]);
    Route::get("showSaves ",[SavesController::class,"showSaves"]);
    Route::get("followed ",[SubsController::class,"followed"]);
    Route::get("showWatched ",[WatchedController::class,"showWatched"]);
    Route::get("deleteCartItem ",[CartController::class,"deleteCartItem"]);
    Route::get("yourCourses ",[CoursesController::class,"getMyCourses"]);
    Route::get("showSellings ",[PurshasesController::class,"showSellings"]);
    
    Route::post('logout',[AuthController::class,"logout"] );
    Route::post('refresh', [AuthController::class,"refresh"] );
    Route::post('me', [AuthController::class,"me"] );

});