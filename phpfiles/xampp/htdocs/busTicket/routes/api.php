<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;


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

Route::post('/register',[PassportAuthController::class,'register']);
Route::post('/login',[PassportAuthController::class,'login']);

Route::post('/companyRegister',[PassportAuthController::class,'companyRegister']);
//Route::post('/companyLogin',[PassportAuthController::class,'companyLogin']);
