<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjrctController;

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

Route::post("register",[StudentController::class,"register"]);
Route::post("login",[StudentController::class,"login"]);

Route::group(["middleware"=>["auth:sanctum"]],function (){

    Route::get("profile",[StudentController::class,"profile"]);
    Route::get("logout",[StudentController::class,"logout"]);

    Route::post("create-project",[ProjrctController::class,"createProject"]);
    Route::get("list-projects",[ProjrctController::class,"listProjects"]);
    Route::get("single-project/{id}",[ProjrctController::class,"singleProject"]);
    Route::delete("delete-project/{id}",[ProjrctController::class,"deleteProject"]);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
