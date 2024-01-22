<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// <project URL>

// Open Routes
Route::post("register", [LoginRegisterController::class, "register"]);
Route::post("login", [LoginRegisterController::class, "login"]);


//protected routes

Route::group([
    "middleware" => ["auth:api"]
],
    function(){

        Route::get("index", [LoginRegisterController::class, "index"]);
        Route::get("logout", [LoginRegisterController::class, "logout"]);
    }
);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
