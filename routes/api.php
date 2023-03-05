<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProfileController;

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


Route::middleware([ 'jwt_verify' 
])->group(function () {


    Route::post("sharecourse ",[CoursesController::class,"sharecourse"]);
    Route::get("recommendedCourses ",[CoursesController::class,"getRecommendedCourses"]);
    Route::get("userdata ",[ProfileController::class,"getUserdata"]);

    
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});